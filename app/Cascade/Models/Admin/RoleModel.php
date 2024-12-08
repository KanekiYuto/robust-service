<?php

namespace App\Cascade\Models\Admin;

use Illuminate\Database\Eloquent\Builder;
use KanekiYuto\Handy\Trace\EloquentTrace;
use KanekiYuto\Handy\Activity\Eloquent\Activity as EloquentActivity;
use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheEloquentTrace;
use KanekiYuto\Handy\Foundation\Activity\Eloquent\Activity as TheActivity;
use Illuminate\Database\Eloquent\Model as Model;

use KanekiYuto\Handy\Foundation\Cast\AutoTimezone;

/**
 * 
 *
 * @author KanekiYuto
*/
class RoleModel extends Model
{

    /**
     * [Eloquent] 模型追踪类
     *
     * @var EloquentTrace
     */
    protected EloquentTrace $eloquentTrace;

    /**
     * 模型生命周期
     *
     * @var EloquentActivity
     */
    protected EloquentActivity $modelActivity;

    /**
     * 模型表名称
     *
     * @var string
     */
    protected $table = TheEloquentTrace::TABLE;

    /**
     * 模型主键 - [ID]
     *
     * @var string
     */
    protected $primaryKey = TheEloquentTrace::PRIMARY_KEY;

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
    protected $hidden = TheEloquentTrace::HIDDEN;

    /**
     * 可大量分配的属性
     *
     * @var array<string>
     */
    protected $fillable = TheEloquentTrace::FILLABLE;

    /**
     * 创建一个 [Eloquent] 模型实例
     *
     * @return void
     */
    public function __construct()
    {
        $this->eloquentTrace = new TheEloquentTrace();
        $this->modelActivity = new TheActivity();

        parent::__construct();
    }

    /**
     * 获取应该强制转换的属性
     *
     * @return array
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
			TheEloquentTrace::ABILITIES => 'json',
			TheEloquentTrace::CREATED_AT => AutoTimezone::class,
			TheEloquentTrace::UPDATED_AT => AutoTimezone::class,
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
        if (!$this->modelActivity->performInsert($this, $query, $this->eloquentTrace)) {
            return false;
        }

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
        if (!$this->modelActivity->performUpdate($this, $query, $this->eloquentTrace)) {
            return false;
        }

        return parent::performUpdate($query);
    }

}
