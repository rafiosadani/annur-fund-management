<?php

namespace Database\Seeders;

use App\Models\GoodInventory;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GoodInventorySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $goods = [
            [
                'item_name'   => 'Karpet Masjid',
                'merk'        => 'Alfateh',
                'description' => 'Karpet tebal ukuran 5x10 meter, warna hijau.',
                'quantity'    => 3,
            ],
            [
                'item_name'   => 'Sound System',
                'merk'        => 'Yamaha',
                'description' => 'Speaker aktif dengan amplifier.',
                'quantity'    => 1,
            ],
            [
                'item_name'   => 'Kipas Angin',
                'merk'        => 'Panasonic',
                'description' => 'Kipas angin berdiri dengan 3 mode kecepatan.',
                'quantity'    => 5,
            ],
            [
                'item_name'   => 'Al-Quran',
                'merk'        => 'Madinah',
                'description' => 'Al-Quran ukuran besar dengan terjemahan.',
                'quantity'    => 20,
            ],
            [
                'item_name'   => 'Lampu LED',
                'merk'        => 'Philips',
                'description' => 'Lampu LED hemat energi untuk aula masjid.',
                'quantity'    => 10,
            ],
        ];

        $year = Carbon::now()->format('y');
        $month = Carbon::now()->format('m');

        foreach ($goods as $index => $good) {
            $good['good_inventory_code'] = 'BRG/' . $year . $month . '/' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            GoodInventory::create([
                'good_inventory_code' => $good['good_inventory_code'],
                'item_name'           => $good['item_name'],
                'merk'                => $good['merk'],
                'description'         => $good['description'],
                'quantity'            => $good['quantity'],
                'created_at'          => Carbon::now(),
                'updated_at'          => Carbon::now(),
                'deleted_at'          => null,
                'created_by'          => null,
                'updated_by'          => null,
                'deleted_by'          => null,
            ]);
        }
    }
}
