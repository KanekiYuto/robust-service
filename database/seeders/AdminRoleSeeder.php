<?php

namespace Database\Seeders;

use App\Ability\Ability;
use App\Models\Models\Admin\Role as AdminRole;
use App\Models\Traces\Admin\Role as TheTrace;
use KanekiYuto\Diverse\Support\Timestamp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

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
        AdminRole::query()->create([
            TheTrace::ID => $roleId,
            TheTrace::NAME => '超级管理员',
            TheTrace::EXPLAIN => '拥有平台所有权限',
            TheTrace::ABILITIES => Ability::uuid(),
        ])->save();

        Cache::put('seeder-admin-role-id', $roleId, 5 * 60);
    }

}
