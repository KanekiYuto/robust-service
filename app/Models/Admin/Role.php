<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Cascade\Models\Admin\AbilityModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Cascade\Trace\Eloquent\AdminRole\AbilityTrace as AdminRoleAbilityTrace;

class Role extends Model
{

    /**
     * 绑定能力信息 [多对多关联]
     *
     * @return BelongsToMany
     */
    public function abilities(): BelongsToMany
    {
        return $this->belongsToMany(
            AbilityModel::class,
            AdminRoleAbilityTrace::TABLE,
            AdminRoleAbilityTrace::ROLE_ID,
            AdminRoleAbilityTrace::ABILITY_ID
        );
    }

}
