<?php

namespace App\Models;

use App\Http\Traits\HasHashid;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    use HasHashid;

    protected $primaryKey = 'id';
}
