<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infaq extends Model
{
    use HasFactory, SoftDeletes, RecordSignature;

    protected $table = 'm_infaq_types';

    protected $guarded = [];

    public $incrementing = false; // Menggunakan UUID

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('infaq_type_name', 'like', '%' . $search . '%')
                    ->orWhere('type_name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        });
    }
}
