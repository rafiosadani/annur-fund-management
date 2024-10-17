<?php

namespace Database\Seeders;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionSeederTableSeeder extends Seeder
{
    private $masterPermissions = [
        'master_donatur.view',
        'master_donatur.create',
        'master_donatur.update',
        'master_donatur.delete',
        'master_infaq.view',
        'master_infaq.create',
        'master_infaq.update',
        'master_infaq.delete',
        'master_roles.view',
        'master_roles.create',
        'master_roles.update',
        'master_roles.delete',
        'master_user.view',
        'master_user.create',
        'master_user.update',
        'master_user.delete',
        'dashboard_dashboard.view',
        'user_profile.view',
        'user_profile.update',
        'user_ubah-password.view',
        'user_ubah-password.update'
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $startTime = Carbon::now();

        foreach ($this->masterPermissions as $key => $permission) {
            Permission::firstOrCreate(['name' => $permission, 'created_at' => $startTime->copy()->addSecond($key+1)]);
        }
    }
}
