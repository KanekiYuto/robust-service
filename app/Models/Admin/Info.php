<?php

namespace App\Models\Admin;

use Laravel\Sanctum\HasApiTokens;
use App\Cascade\Models\Admin\RoleModel;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Model;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Info extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    public function casts(): array
    {
        return [];
    }

    /**
     * 绑定管理员权限表 [一对一关联]
     *
     * @return HasOne
     */
    public function role(): HasOne
    {
        return $this->hasOne(
            RoleModel::class,
            RoleTrace::ID,
            InfoTrace::ADMIN_ROLE_ID
        );
    }

}
