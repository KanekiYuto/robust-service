<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use KanekiYuto\Diverse\Support\Timestamp;
use App\Cascade\Models\Admin\AbilityModel;
use App\Cascade\Trace\Eloquent\Admin\AbilityTrace;
use App\Cascade\Models\Admin\RoleModel as AdminRole;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;

/**
 * 管理员角色填充
 *
 * @author KanekiYuto
 */
class AdminRoleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $roleId = Timestamp::millisecond();
        $abilities = AbilityModel::query()
            ->pluck(AbilityTrace::CURRENT_UUID)
            ->all();

        AdminRole::query()->create([
            TheTrace::ID => $roleId,
            TheTrace::NAME => '超级管理员',
            TheTrace::EXPLAIN => '拥有平台所有权限',
            TheTrace::ABILITIES => $abilities,
        ])->save();

        Cache::put('seeder-admin-role-id', $roleId, 5 * 60);

        $this->callOnce([
            AdminInfoSeeder::class
        ]);
    }

}
