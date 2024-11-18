<?php

use App\Models\Traces\Admin\Info as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理員信息
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
            $table->bigInteger(TheTrace::ID)->primary()->unique()->comment('管理员ID');
            $table->string(TheTrace::ACCOUNT, 32)->comment('账号');
            $table->bigInteger(TheTrace::ADMIN_ROLE_ID)->index()->comment('角色ID');
            $table->string(TheTrace::EMAIL, 32)->comment('邮箱');
            $table->string(TheTrace::PASS, 512)->comment('密码');
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
