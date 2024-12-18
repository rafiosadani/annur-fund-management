<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GoodDonation extends Model
{
    protected $table = 't_good_donations';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $loginModel = auth()->user();

            $model->{$model->getKeyName()} = RecordSignature::generateHashid();
            $model->created_at = date("Y-m-d H:i:s");
            $model->created_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
            $model->updated_at = date("Y-m-d H:i:s");
            $model->updated_by = $loginModel ? (isset($loginModel->id) ? (string)$loginModel->id : null) : null;
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'm_user_id', 'id');
    }

    public function good(): BelongsTo
    {
        return $this->belongsTo(GoodInventory::class, 'm_good_inventory_id', 'id');
    }

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
                $query->where('good_donation_code', 'like', '%' . $search . '%')
                    ->orWhere('quantity', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%')
                    ->orWhereHas('good', function ($query) use ($search) {
                        $query->where('item_name', 'like', '%' . $search . '%');
                    })->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('dibuat', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
