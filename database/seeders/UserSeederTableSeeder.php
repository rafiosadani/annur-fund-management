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
        $year = Carbon::now()->format('y'); // Last two digits of the current year
        $month = Carbon::now()->format('m'); // two digits month

        $administratorRoleId = Role::where('name', 'Administrator')->pluck('id')->first();
        $donorRoleId = Role::where('name', 'Donatur')->pluck('id')->first();

        User::create([
            'm_role_id'     => $administratorRoleId,
            'user_code'     => 'USR/' . $year . $month . '/0001',
            'name'          => 'Administrator',
            'email'         => 'administrator@gmail.com',
            'gender'        => null,
            'phone'         => null,
            'address'       => null,
            'password'      => Hash::make('password'),
            'image'         => 'default.png',
            'remember_token'=> Str::random(10),
        ]);

        User::create([
            'm_role_id'     => $donorRoleId,
            'user_code'     => 'USR/' . $year . $month . '/0002',
            'name'          => 'Agus Subiyanto',
            'email'         => 'agussubiyanto@gmail.com',
            'gender'        => 'laki-laki',
            'phone'         => '085235645345',
            'address'       => 'Bandung, Jawa Barat, Indonesia',
            'password'      => Hash::make('password'),
            'image'         => 'default.png',
            'remember_token'=> Str::random(10),
        ]);

        User::create([
            'm_role_id'     => $donorRoleId,
            'user_code'     => 'USR/' . $year . $month . '/0003',
            'name'          => 'Budi Gunadi Sadikin',
            'email'         => 'budigunadis@gmail.com',
            'gender'        => 'laki-laki',
            'phone'         => '085235645765',
            'address'       => 'Bandung, Jawa Barat, Indonesia',
            'password'      => Hash::make('password'),
            'image'         => 'default.png',
            'remember_token'=> Str::random(10),
        ]);

        User::where('email', 'administrator@gmail.com')->first()->assignRole('Administrator');
        User::where('email', 'agussubiyanto@gmail.com')->first()->assignRole('Donatur');
        User::where('email', 'budigunadis@gmail.com')->first()->assignRole('Donatur');
    }
}
