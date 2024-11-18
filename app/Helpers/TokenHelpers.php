<?php

namespace App\Helpers;

use KanekiYuto\Diverse\Support\Timestamp;

/**
 * 令牌助手
 *
 * @author KanekiYuto
 */
class TokenHelpers
{

    /**
     * 签发令牌
     *
     * @param  object  $model
     * @param  array  $ability
     * @param  int  $validity
     * @return array
     */
    public static function issue(
        object $model,
        array $ability = [],
        int $validity = 30 * 60
    ): array {
        // 删除过去签发的所有令牌
        $model->tokens()->delete();

        // 签发令牌
        $token = $model->createToken(
            $model->id,
            $ability,
            Timestamp::validity(time(), $validity),
        );

        return explode('|', $token->plainTextToken);
    }

}
