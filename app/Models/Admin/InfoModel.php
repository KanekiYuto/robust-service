<?php

namespace App\Models\Admin;

use KanekiYuto\Handy\Cascades\Model\BaseModel as Model;
use App\Trace\Eloquent\Admin\InfoTrace as TheTrace;

/**
 * 管理员信息表
 *
 * @author KanekiYuto
*/
class InfoModel extends Model
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
     * 创建一个新的 [Eloquent] 模型实例
     *
     * @param  array  $attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        $this->fillable = array_values(TheTrace::getAllColumns());
        parent::__construct($attributes);
    }

    /**
     * 获取应该强制转换的属性
     *
     * @return array
     */
    public function casts(): array
    {
        return [
			TheTrace::CREATED_AT => 'App\Casts\AutoTimezone',
			TheTrace::UPDATED_AT => 'App\Casts\AutoTimezone',
		];
    }

}
