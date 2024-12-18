<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoodInventory extends Model
{
    use RecordSignature;

    protected $table = 'm_good_inventories';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function dibuat(): HasOne
    {
        return $this->hasOne(User::class, "id", "created_by");
    }

    public function getCreatedAtAttribute() {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y H:i:s');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('item_name', 'like', '%' . $search . '%')
                    ->orWhereHas('dibuat', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
