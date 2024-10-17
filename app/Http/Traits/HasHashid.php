<?php

namespace App\Http\Traits;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Support\Str;

trait HasHashid
{
    protected static function bootHasHashid()
    {
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = self::generateHashid();
        });
    }

    public static function generateHashid($length = 36)
    {
        // Menghasilkan string acak
        $randomString = Str::random($length / 2); // Membuat setengah panjang dari yang diinginkan

        // Mengubah string acak menjadi hashid
        $hashid = Hashids::encode(hexdec(bin2hex($randomString)));

        // Menambahkan karakter acak hingga panjangnya mencapai 36 karakter
        while (strlen($hashid) < $length) {
            $hashid .= Str::random(1); // Menambahkan karakter acak
        }

        // Memastikan panjang hashid tepat 36 karakter
        return substr($hashid, 0, $length); // Memotong jika lebih panjang
    }

    public function getIncrementing()
    {
        return false; // Mengatur ID tidak menggunakan auto-increment
    }

    public function getKeyType()
    {
        return 'string'; // Mengatur tipe kunci menjadi string
    }
}
