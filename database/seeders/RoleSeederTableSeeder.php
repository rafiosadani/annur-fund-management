<?php

namespace Database\Seeders;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RoleSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        $administrator = Role::create(['name' => 'Administrator']);
        $donor = Role::create(['name' => 'Donatur']);

        $allPermission = Permission::all();

        $administrator->givePermissionTo($allPermission);
        $donor->givePermissionTo([
            'dashboard_dashboard.view',
            'user_profile.view',
            'user_profile.update',
            'user_ubah-password.view',
            'user_ubah-password.update'
        ]);
    }
}
