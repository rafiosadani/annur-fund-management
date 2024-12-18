<?php

namespace Database\Seeders;

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class PermissionSeederTableSeeder extends Seeder
{
    private $masterPermissions = [
        'master_barang.view',
        'master_barang.create',
        'master_barang.update',
        'master_barang.delete',
        'master_donatur.view',
        'master_donatur.create',
        'master_donatur.update',
        'master_donatur.delete',
        'master_infaq.view',
        'master_infaq.create',
        'master_infaq.update',
        'master_infaq.delete',
        'master_program-penggalangan-dana.view',
        'master_program-penggalangan-dana.create',
        'master_program-penggalangan-dana.update',
        'master_program-penggalangan-dana.delete',
        'master_roles.view',
        'master_roles.create',
        'master_roles.update',
        'master_roles.delete',
        'master_user.view',
        'master_user.create',
        'master_user.update',
        'master_user.delete',
        'transaksi-pemasukan_donasi-offline.view',
        'transaksi-pemasukan_donasi-offline.create',
        'transaksi-pemasukan_donasi-offline.update',
        'transaksi-pemasukan_donasi-offline.delete',
        'transaksi-pemasukan_infaq.view',
        'transaksi-pemasukan_infaq.create',
        'transaksi-pemasukan_infaq.update',
        'transaksi-pemasukan_infaq.delete',
        'transaksi-pemasukan_konfirmasi-transfer-donatur.view',
        'transaksi-pemasukan_konfirmasi-transfer-donatur.create',
        'transaksi-pengeluaran_pengeluaran-umum.view',
        'transaksi-pengeluaran_pengeluaran-umum.create',
        'transaksi-pengeluaran_pengeluaran-program.view',
        'transaksi-pengeluaran_pengeluaran-program.create',
        'transaksi-barang_donasi-barang.view',
        'transaksi-barang_donasi-barang.create',
        'laporan_donasi-barang.view',
        'laporan_pemasukan.view',
        'laporan_pengeluaran.view',
        'laporan_program-penggalangan-dana.view',
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
