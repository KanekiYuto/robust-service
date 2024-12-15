<?php

namespace App\Cascade\Models\PersonalAccess;

use Illuminate\Database\Eloquent\Builder;
use Handyfit\Framework\Trace\EloquentTrace;
use Handyfit\Framework\Hook\Eloquent as EloquentHook;
use App\Cascade\Trace\Eloquent\PersonalAccess\TokensTrace as TheEloquentTrace;
use Handyfit\Framework\Foundation\Hook\Eloquent as TheEloquentHook;
use Laravel\Sanctum\PersonalAccessToken as Model;



/**
 * 
 *
 * @author KanekiYuto
*/
class TokensModel extends Model
{

    /**
     * [Eloquent] 模型追踪类
     *
     * @var EloquentTrace
     */
    protected EloquentTrace $eloquentTrace;

    /**
     * 模型钩子
     *
     * @var EloquentHook
     */
    protected EloquentHook $eloquentHook;

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
        $this->eloquentHook = new TheEloquentHook();

        parent::__construct();
    }

    /**
     * 获取应该强制转换的属性
     *
     * @return array
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), []);
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
        if (!$this->eloquentHook->performInsert($this, $query, $this->eloquentTrace)) {
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
        if (!$this->eloquentHook->performUpdate($this, $query, $this->eloquentTrace)) {
            return false;
        }

        return parent::performUpdate($query);
    }

}
