<?php

namespace App\Models\Models\Admin;

use App\Casts\AutoTimezone;
use App\Models\Traces\Admin\Log as TheTrace;
use App\Models\Models\Admin\Info as AdminInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use KanekiYuto\Diverse\Support\Timestamp;

/**
 * 管理员日志模型
 *
 * @author KanekiYuto
*/
class Log extends Model
{

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
    protected $primaryKey = TheTrace::ID;

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
    protected $hidden = TheTrace::HIDE;

    /**
     * 可大量分配的属性
     *
     * @var array<string>
     */
    protected $fillable = [];

    /**
     * 应该强制转换的属性
     *
     * @var array
     */
    protected $casts = [
        TheTrace::PAYLOAD => 'json',
        TheTrace::HEADERS => 'json',
        TheTrace::RESPONSE => 'json',
        TheTrace::UPDATED_AT => AutoTimezone::class,
        TheTrace::CREATED_AT => AutoTimezone::class,
    ];

    /**
     * 创建一个新的 Eloquent 模型实例
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = array_values(TheTrace::getAllColumns());
        parent::__construct($attributes);
    }

    /**
     * 创建前执行的操作
     *
     * @param  Builder  $query
     * @return bool
     */
    protected function performInsert(Builder $query): bool
    {
        if (empty($this->getAttribute(TheTrace::ID))) {
            $this->setAttribute(TheTrace::ID, Timestamp::millisecond());
        }

        $this->setAttribute(TheTrace::CREATED_AT, Timestamp::second());
        $this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

        return parent::performInsert($query);
    }

    /**
     * 执行一个模型更新操作
     *
     * @param  Builder  $query
     * @return bool
     */
    protected function performUpdate(Builder $query): bool
    {
        // 维护时间戳
        $this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

        return parent::performUpdate($query);
    }

    /**
     * 绑定管理员信息表 [一对一关联]
     *
     * @return HasOne
     */
    public function admin(): HasOne
    {
        return $this->hasOne(
            AdminInfo::class,
            'id',
            'admin_id'
        );
    }

}
