<?php

use App\Models\Traces\PersonalAccessToken as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 私人授权令牌
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
            $table->bigInteger(TheTrace::ID)->comment('私人访问令牌ID');
            $table->morphs(TheTrace::TOKENABLE);
            $table->string(TheTrace::NAME);
            $table->string(TheTrace::TOKEN, 64)->unique();
            $table->text(TheTrace::ABILITIES)->nullable();
            $table->timestamp(TheTrace::LAST_USED_AT)->nullable()->comment('最后使用时间');
            $table->timestamp(TheTrace::EXPIRES_AT)->nullable()->comment('过期时间');
            $table->bigInteger(TheTrace::CREATED_AT)->comment('创建时间');
            $table->bigInteger(TheTrace::UPDATED_AT)->comment('修改时间');
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
