<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donation extends Model
{
    protected $table = 't_donations';

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

    public function fundraisingProgram(): BelongsTo
    {
        return $this->belongsTo(FundraisingProgram::class, 'm_fundraising_program_id', 'id');
    }

//    public function user(): HasOne
//    {
//        return $this->hasOne(User::class, 'id', 'm_user_id');
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'm_user_id', 'id');
    }

    public function donorProfile(): BelongsTo
    {
        return $this->belongsTo(DonorProfile::class, 'm_donor_profile_id', 'id');
    }

    public function dibuat(): HasOne
    {
        return $this->hasOne(User::class, "id", "created_by");
    }

    public function getCreatedAtAttribute() {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y H:i:s');
    }

    public function getUpdatedAtAttribute() {
        return Carbon::parse($this->attributes['updated_at'])->translatedFormat('d F Y H:i:s');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('amount', 'like', '%' . $search . '%')
                    ->orWhere('donation_code', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->where('is_anonymous', '0');
                    })->orWhereHas('donorProfile', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('fundraisingProgram', function ($query) use ($search) {
                        $query->where('title', 'like', '%' . $search . '%');
                    })->orWhereHas('dibuat', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });

        if (isset($filters['filterAnonymous']) && $filters['filterAnonymous'] !== '') {

            $filterAnonymous = (int) $filters['filterAnonymous'];

            return $query->where(function ($query) use ($filterAnonymous) {
                $query->whereHas('user', function ($query) use ($filterAnonymous) {
                    $query->where('is_anonymous', $filterAnonymous);
                })->orWhereHas('donorProfile', function ($query) use ($filterAnonymous) {
                    $query->where('is_anonymous', $filterAnonymous);
                });
            });
        }
    }
}
