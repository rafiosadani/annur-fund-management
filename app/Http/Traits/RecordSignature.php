<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Vinkla\Hashids\Facades\Hashids;

trait RecordSignature
{
    use SoftDeletes;

    protected static function bootRecordSignature()
    {
        static::creating(function ($model) {
            $loginModel = auth()->user();

            $model->{$model->getKeyName()} = self::generateHashid();
            $model->created_at = date("Y-m-d H:i:s");
            $model->created_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
            $model->updated_at = date("Y-m-d H:i:s");
            $model->updated_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
        });

        static::updating(function ($model) {
            $loginModel = auth()->user();

            $model->updated_at = date("Y-m-d H:i:s");
            $model->updated_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
        });

        static::deleting(function ($model) {
            $loginModel = auth()->user();

            $model->deleted_at = date("Y-m-d H:i:s");
            $model->deleted_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
            $model->save();
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
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }
}
