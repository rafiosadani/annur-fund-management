<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InfaqTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_infaq_types')->insert([
            [
                'id' => Str::uuid(),
                'infaq_type_code' => 'INFAQ001',
                'type_name' => 'Infaq Masjid',
                'description' => 'Infaq yang diberikan untuk kebutuhan masjid, seperti perbaikan, perawatan, atau kegiatan keagamaan.',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'infaq_type_code' => 'INFAQ002',
                'type_name' => 'Infaq Pendidikan',
                'description' => 'Infaq yang digunakan untuk kegiatan pendidikan, seperti bantuan operasional sekolah atau pengadaan alat belajar.',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => Str::uuid(),
                'infaq_type_code' => 'INFAQ003',
                'type_name' => 'Infaq Sosial',
                'description' => 'Infaq yang diberikan untuk kegiatan sosial, seperti bantuan kepada fakir miskin atau korban bencana.',
                'created_by' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
