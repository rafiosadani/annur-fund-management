<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'role_name' => 'Administrator',
                'name' => 'Administrator',
                'email' => 'administrator@gmail.com',
                'gender' => 'laki-laki',
                'phone' => '085755558654',
                'address' => 'Jl. Soekarno Hatta No.9, Jatimulyo, Kec. Lowokwaru, Kota Malang, Jawa Timur 65141',
                'password' => Hash::make('password'),
                'image' => 'default.png',
            ],
            [
                'role_name' => 'Donatur',
                'name' => 'Agus Subiyanto',
                'email' => 'agussubiyanto@gmail.com',
                'gender' => 'laki-laki',
                'phone' => '085235645345',
                'address' => 'Bandung, Jawa Barat, Indonesia',
                'password' => Hash::make('password'),
                'image' => 'default.png',
            ],
            [
                'role_name' => 'Donatur',
                'name' => 'Budi Gunadi Sadikin',
                'email' => 'budigunadis@gmail.com',
                'gender' => 'laki-laki',
                'phone' => '085235645765',
                'address' => 'Bandung, Jawa Barat, Indonesia',
                'password' => Hash::make('password'),
                'image' => 'default.png',
            ],
        ];

        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        foreach ($users as $index => $user) {
            $roleId = Role::where('name', $user['role_name'])->pluck('id')->first();

            $user['user_code'] = 'USR/' . $year . $month . '/' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            User::create([
                'm_role_id'      => $roleId,
                'user_code'      => $user['user_code'],
                'name'           => $user['name'],
                'email'          => $user['email'],
                'gender'         => $user['gender'],
                'phone'          => $user['phone'],
                'address'        => $user['address'],
                'password'       => $user['password'],
                'image'          => $user['image'],
                'remember_token' => Str::random(10),
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
                'deleted_at'          => null,
                'created_by'          => null,
                'updated_by'          => null,
                'deleted_by'          => null,
            ]);

            User::where('email', $user['email'])->first()->assignRole($user['role_name']);
        }
    }
}
