<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FundraisingProgram extends Model
{
    use RecordSignature;

    protected $table = 'm_fundraising_programs';

    protected $primaryKey = 'id';

    protected $guarded = [];

    public function images(): HasMany
    {
        return $this->hasMany(FundraisingProgramImage::class, "m_fundraising_program_id", "id");
    }

    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, "m_fundraising_program_id", "id");
    }

    public function dibuat(): HasOne
    {
        return $this->hasOne(User::class, "id", "created_by");
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhereHas('dibuat', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
