<?php

namespace App\Models\Admin;

use Laravel\Sanctum\HasApiTokens;
use App\Cascade\Models\Admin\RoleModel;
use Illuminate\Notifications\Notifiable;
use App\Cascade\Trace\Eloquent\Admin\InfoTrace;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Info extends Model
{

    use HasApiTokens, HasFactory, Notifiable;

    public function casts(): array
    {
        return [
            RoleTrace::ABILITIES => 'json',
        ];
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
