<?php

namespace App\Cascade\Models\Admin;

use App\Models\BaseModel as Model;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;
use Illuminate\Database\Eloquent\Builder;

use KanekiYuto\Handy\Foundation\Cast\AutoTimezone;

/**
 * 管理员权限表
 *
 * @author KanekiYuto
*/
class RoleModel extends Model
{

    /**
     * 追踪类
     *
     * @var string
     */
    protected string $trace = TheTrace::class;

    /**
     * 模型表名称
     *
     * @var string
     */
    protected $table = TheTrace::TABLE;

    /**
     * 模型主键 ID
     *
     * @var string
     */
    protected $primaryKey = TheTrace::PRIMARY_KEY;

    /**
     * 主键是否自增
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * 指示模型是否主动维护时间戳
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 需要被隐藏的列属性
     *
     * @var array<int, string>
     */
    protected $hidden = TheTrace::HIDDEN;

    /**
     * 可大量分配的属性
     *
     * @var array<string>
     */
    protected $fillable = TheTrace::FILLABLE;

    /**
     * 获取应该强制转换的属性
     *
     * @return array
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
			TheTrace::ABILITIES => 'json',
			TheTrace::CREATED_AT => AutoTimezone::class,
			TheTrace::UPDATED_AT => AutoTimezone::class,
		]);
    }

    /**
     * 创建前执行的操作
     *
     * @param  Builder  $query
     *
     * @return bool
     */
    protected function performInsert(Builder $query): bool
    {
        return parent::performInsert($query);
    }

    /**
     * 执行一个模型更新操作
     *
     * @param  Builder  $query
     *
     * @return bool
     */
    protected function performUpdate(Builder $query): bool
    {
        return parent::performUpdate($query);
    }

}
