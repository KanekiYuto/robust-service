<?php

namespace Kaneki\Diverse\Database\Schema;

use Closure;
use Illuminate\Database\Schema\Blueprint as LaravelBlueprint;
use Illuminate\Support\Facades\Schema as LaravelSchema;

class Builder
{

    private static string $table;

    private static string $comment;

    public static function create(string $table, Closure $callback, string $comment = ''): void
    {
        self::$table = $table;
        self::$comment = $comment;

        LaravelSchema::create(self::$table, function (LaravelBlueprint $table) use ($callback) {
            $callback(new Blueprint(self::$table, $table, self::$comment));
        });
    }

    public static function dropIfExists(string $table): void
    {
        LaravelSchema::dropIfExists($table);
    }

}
