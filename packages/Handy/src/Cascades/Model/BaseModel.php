<?php

namespace KanekiYuto\Handy\Cascades\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * 基础模型
 *
 * @author KanekiYuto
 */
class BaseModel extends Model
{

    /**
     * 应该强制转换的属性
     *
     * @return array
     */
    public function casts(): array
    {
        return [];
    }

}
