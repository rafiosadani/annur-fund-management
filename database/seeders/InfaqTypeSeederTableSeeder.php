<?php

namespace Database\Seeders;

use App\Models\Infaq;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InfaqTypeSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $infaqTypes = [
            [
                'type_name'   => 'Infaq Jariyah',
                'description' => 'Infaq yang digunakan untuk pembangunan dan perawatan fasilitas masjid.',
            ],
            [
                'type_name'   => 'Infaq Kegiatan Sosial',
                'description' => 'Infaq yang dialokasikan untuk kegiatan sosial seperti membantu fakir miskin dan yatim piatu.',
            ],
            [
                'type_name'   => 'Infaq Operasional',
                'description' => 'Infaq yang digunakan untuk kebutuhan operasional masjid seperti listrik, air, dan kebersihan.',
            ],
            [
                'type_name'   => 'Infaq Pendidikan',
                'description' => 'Infaq untuk mendukung kegiatan pendidikan seperti TPA atau madrasah.',
            ],
            [
                'type_name'   => 'Infaq Ramadhan',
                'description' => 'Infaq khusus untuk kegiatan selama bulan Ramadhan, seperti buka puasa bersama dan santunan.',
            ],
            [
                'type_name'   => 'Infaq Hari Jumat',
                'description' => 'Infaq yang dikumpulkan setiap hari Jumat untuk keperluan masjid.',
            ],
            [
                'type_name'   => 'Infaq Kotak Amal',
                'description' => 'Infaq yang berasal dari kotak amal yang tersedia di masjid.',
            ],
        ];

        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        foreach ($infaqTypes as $index => $infaqType) {
            $infaqType['infaq_type_code'] = 'INQ/' . $year . $month . '/' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            Infaq::create([
                'infaq_type_code' => $infaqType['infaq_type_code'],
                'type_name'     => $infaqType['type_name'],
                'description'   => $infaqType['description'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]);
        }
    }
}
