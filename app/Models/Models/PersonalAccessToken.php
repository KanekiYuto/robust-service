<?php

namespace App\Models\Models;

use App\Models\Traces\PersonalAccessToken as TheTrace;
use KanekiYuto\Diverse\Support\Timestamp;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

/**
 * 私有授权令牌信息类模型
 *
 * @author KanekiYuto
 */
class PersonalAccessToken extends SanctumPersonalAccessToken
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
        mt_srand();
        $uuid = (int) (Timestamp::millisecond().mt_rand(100000, 999999));

        $this->setAttribute(TheTrace::ID, $uuid);
        $this->setAttribute(TheTrace::CREATED_AT, Timestamp::second());
        $this->setAttribute(TheTrace::UPDATED_AT, Timestamp::second());

        return parent::performInsert($query);
    }

}
