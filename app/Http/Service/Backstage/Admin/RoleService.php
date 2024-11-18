<?php

namespace App\Http\Service\Backstage\Admin;

use App\Models\Models\Admin\Role as AdminRole;
use App\Models\Traces\Admin\Role as TheTrace;
use Kaneki\Diverse\Equation\Equation;
use Kaneki\Diverse\Equation\Formulas;
use Kaneki\Diverse\PagingQuery\PagingQuery;
use KanekiYuto\Diverse\Preacher\Preacher;

/**
 * 管理员角色服务类
 *
 * @author KanekiYuto
 */
class RoleService
{

    /**
     * 分页查询管理员角色信息
     *
     * @param  int  $page
     * @param  int  $prePage
     * @param  string  $oderBy
     * @param  string  $order
     * @param  array  $query
     * @return Preacher
     */
    public static function paging(
        int $page,
        int $prePage,
        string $oderBy,
        string $order,
        array $query
    ): Preacher {
        $model = AdminRole::query();

        $model = Equation::build(model: $model)->where(
            (new Formulas($query))->formula(column: 'id')
        );

        return PagingQuery::response(
            model: $model->export(),
            page: $page,
            prePage: $prePage,
            oderBy: $oderBy,
            order: $order,
            columns: $model->getColumns()
        );
    }

    /**
     * 管理员角色选项
     *
     * @return Preacher
     */
    public static function select(): Preacher
    {
        $model = AdminRole::query();

        $model = Equation::build(
            model: $model,
            columns: [TheTrace::ID, TheTrace::NAME],
            aliases: [TheTrace::ID => 'value', TheTrace::NAME => 'label']
        );

        $model = $model->export()->get($model->getColumns());

        return Preacher::rows($model->toArray());
    }

    /**
     * 新增管理员角色信息
     *
     * @param  string  $name
     * @param  string  $explain
     * @return Preacher
     */
    public static function append(string $name, string $explain): Preacher
    {
        $model = AdminRole::query();

        $model = $model->create([
            TheTrace::NAME => $name,
            TheTrace::EXPLAIN => $explain,
            TheTrace::ABILITIES => [],
        ]);

        return Preacher::allow(
            $model->save(),
            Preacher::msg('新增成功'),
            Preacher::msgCode(
                Preacher::RESP_CODE_FAIL,
                '新增失败'
            ),
        );
    }

    /**
     * 修改管理员角色信息
     *
     * @param  int  $id
     * @param  string  $name
     * @param  string  $explain
     * @return Preacher
     */
    public static function modify(
        int $id,
        string $name,
        string $explain
    ): Preacher {
        $model = AdminRole::query()->find($id);

        $column = TheTrace::NAME;
        $model->$column = $name;
        $column = TheTrace::EXPLAIN;
        $model->$column = $explain;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(
                Preacher::RESP_CODE_FAIL,
                '修改失败'
            ),
        );
    }

    /**
     * 设置角色能力
     *
     * @param  int  $id
     * @param  array  $abilities
     * @return Preacher
     */
    public static function ability(int $id, array $abilities): Preacher
    {
        $model = AdminRole::query()->find($id);

        $column = TheTrace::ABILITIES;
        $model->$column = $abilities;

        return Preacher::allow(
            $model->save(),
            Preacher::msg('修改成功'),
            Preacher::msgCode(
                Preacher::RESP_CODE_FAIL,
                '修改失败'
            ),
        );
    }

}
