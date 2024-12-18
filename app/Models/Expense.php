<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    protected $table = 't_expenses';

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

    public function dibuat(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function getCreatedAtAttribute() {
        return Carbon::parse($this->attributes['created_at'])->translatedFormat('d F Y');
    }

    public static function calculateInfaqSummary()
    {
        $totalInfaq = intval(InfaqDonation::sum('amount'));

        $totalGeneralExpenses = intval(Expense::where('type', 'general')->sum('amount'));

        $endingBalance = intval($totalInfaq - $totalGeneralExpenses) ?? 0;

        return [
            'totalInfaq' => $totalInfaq,
            'totalGeneralExpenses' => $totalGeneralExpenses,
            'endingBalance' => $endingBalance,
        ];
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('expense_code', 'like', '%' . $search . '%')
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhereHas('dibuat', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%');
                    });
            });
        });
    }
}
