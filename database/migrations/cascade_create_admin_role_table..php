<?php

use App\Cascade\Trace\Eloquent\Admin\RoleTrace as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Migration [管理员权限表]
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
            $table->string(column: TheTrace::ID)->primary()->unique()->comment(comment: '管理员角色ID');
			$table->string(column: TheTrace::NAME, length: 32)->comment(comment: '管理员角色名称');
			$table->string(column: TheTrace::EXPLAIN, length: 64)->nullable()->comment(comment: '管理员角色说明');
			$table->json(column: TheTrace::ABILITIES)->comment(comment: '管理员角色能力');
			$table->string(column: TheTrace::CREATED_AT)->comment(comment: '创建时间');
			$table->string(column: TheTrace::UPDATED_AT)->comment(comment: '修改时间');
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
