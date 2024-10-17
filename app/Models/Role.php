<?php

namespace App\Models;

use App\Http\Traits\RecordSignature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use softDeletes, RecordSignature;

    protected $table = 'm_roles';

    protected $primaryKey = 'id';

    protected $guarded = [];
}
