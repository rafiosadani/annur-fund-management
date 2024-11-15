<?php

namespace Database\Seeders;

use App\Models\FundraisingProgram;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class FundraisingProgramSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYearMonth = Carbon::now()->format('y') . Carbon::now()->format('m');

        $fundraisingPrograms = [
            [
                'title' => 'Penggalangan Dana Renovasi Masjid',
                'target_amount' => 50000000,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(60),
                'status' => 'active',
                'description' => 'Penggalangan dana untuk renovasi bagian atap dan tembok masjid.',
            ],
            [
                'title' => 'Bantuan Pendidikan Anak Yatim',
                'target_amount' => 30000000,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(90),
                'status' => 'active',
                'description' => 'Membantu anak yatim mendapatkan akses pendidikan yang lebih baik.',
            ],
            [
                'title' => 'Dana Bencana Alam',
                'target_amount' => 20000000,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(30),
                'status' => 'active',
                'description' => 'Penggalangan dana untuk korban bencana alam.',
            ],
            [
                'title' => 'Program Beasiswa Tahfidz',
                'target_amount' => 40000000,
                'start_date' => Carbon::now()->subDays(15),
                'end_date' => Carbon::now()->addDays(120),
                'status' => 'active',
                'description' => 'Bantuan biaya pendidikan untuk tahfidz Qur\'an.',
            ],
            [
                'title' => 'Pembangunan Toilet Umum',
                'target_amount' => 25000000,
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->addDays(80),
                'status' => 'active',
                'description' => 'Dana untuk pembangunan toilet umum di area masjid.',
            ],
            [
                'title' => 'Pengadaan Buku-buku Islami',
                'target_amount' => 15000000,
                'start_date' => Carbon::now()->subDays(25),
                'end_date' => Carbon::now()->addDays(70),
                'status' => 'active',
                'description' => 'Penggalangan dana untuk pembelian buku-buku islami di perpustakaan masjid.',
            ],
        ];

        foreach ($fundraisingPrograms as $index => $program) {
            FundraisingProgram::create([
                'fundraising_program_code' => 'PRG/' . $currentYearMonth . '/' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'title' => $program['title'],
                'target_amount' => $program['target_amount'],
                'start_date' => $program['start_date'],
                'end_date' => $program['end_date'],
                'status' => $program['status'],
                'description' => $program['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null,
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
            ]);
        }
    }
}
