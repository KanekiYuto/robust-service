<?php

use App\Cascade\Trace\Eloquent\PersonalAccess\TokensTrace as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Migration []
 *
 * @author KanekiYuto
 */
return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(TheTrace::TABLE, function (Blueprint $table) {
            $table->bigInteger(column: TheTrace::ID)->comment(comment: '私人访问令牌ID');
			$table->morphs(name: TheTrace::TOKENABLE);
			$table->string(column: TheTrace::NAME)->comment(comment: '令牌名称');
			$table->string(column: TheTrace::TOKEN, length: 64)->unique()->comment(comment: '令牌内容');
			$table->text(column: TheTrace::ABILITIES)->nullable()->comment(comment: '令牌能力');
			$table->timestamp(column: TheTrace::LAST_USED_AT)->nullable()->comment(comment: '令牌最终使用时间');
			$table->timestamp(column: TheTrace::EXPIRES_AT)->nullable()->comment(comment: '令牌过期时间');
			$table->bigInteger(column: TheTrace::CREATED_AT)->comment(comment: '创建时间');
			$table->bigInteger(column: TheTrace::UPDATED_AT)->comment(comment: '修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(TheTrace::TABLE);
    }

};
