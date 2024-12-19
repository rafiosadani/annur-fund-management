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

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, "m_fundraising_program_id", "id")->where('type', 'program');
    }

    public function dibuat(): HasOne
    {
        return $this->hasOne(User::class, "id", "created_by");
    }

    public static function loadWithDetails($id, $additionalConditions = [])
    {
        $query = self::with(['dibuat', 'images'])
            ->withSum(['donations as total_donated' => function ($query) {
                $query->where('status', 'confirmed');
            }], 'amount')
            ->withSum(['expenses as total_expense' => function ($query) {
                $query->where('type', 'program');
            }], 'amount')
            ->whereNull('deleted_at')
            ->whereIn('status', ['active', 'completed'])
            ->where('id', $id);

        foreach ($additionalConditions as $column => $value) {
            $query->where($column, $value);
        }

        $fundraisingProgram = $query->first();

        if ($fundraisingProgram) {
            $fundraisingProgram->total_donated = intval($fundraisingProgram->total_donated) ?? 0;
            $fundraisingProgram->total_expense = intval($fundraisingProgram->total_expense) ?? 0;
            $fundraisingProgram->remaining_donations = intval(($fundraisingProgram->total_donated ?? 0) - ($fundraisingProgram->total_expense ?? 0)) ?? 0;
        }

        return $fundraisingProgram;
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

        $query->when($filters['program_status'] ?? false, function($query, $programStatus) {
            return $query->where('status', $programStatus);
        });
    }
}
