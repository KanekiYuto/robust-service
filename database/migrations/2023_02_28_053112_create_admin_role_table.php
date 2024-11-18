<?php

use App\Models\Traces\Admin\Role as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理員角色
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
            $table->bigInteger(TheTrace::ID)->primary()->unique()->comment('管理员角色ID');
            $table->string(TheTrace::NAME, 32)->comment('管理员角色名称');
            $table->string(TheTrace::EXPLAIN, 64)->nullable()->comment('管理员角色说明');
            $table->json(TheTrace::ABILITIES)->comment('管理员角色能力');
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
