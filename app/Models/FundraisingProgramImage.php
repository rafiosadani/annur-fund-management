<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FundraisingProgramImage extends Model
{
    protected $table = 'm_fundraising_program_images';

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

    public function fundraisingProgram(): BelongsTo {
        return $this->belongsTo(FundraisingProgram::class, 'm_fundraising_program_id', 'id');
    }
}
