<?php

use App\Cascade\Trace\Eloquent\Admin\AbilityTrace as TheTrace;
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
            $table->bigInteger(column: TheTrace::ID)->primary()->unique()->comment(comment: '能力 - [ID]');
			$table->string(column: TheTrace::NAME, length: 32)->comment(comment: '能力名称');
			$table->string(column: TheTrace::EXPLAIN, length: 64)->nullable()->comment(comment: '能力解释');
			$table->uuid(column: TheTrace::CURRENT_UUID)->comment(comment: '唯一标识');
			$table->uuid(column: TheTrace::PARENT_UUID)->comment(comment: '父级唯一标识');
			$table->json(column: TheTrace::SERVER_ROUTING)->comment(comment: '服务端路由');
			$table->json(column: TheTrace::CLIENT_ROUTING)->comment(comment: '客户端路由');
			$table->json(column: TheTrace::OPERATION)->comment(comment: '允许操作的权限');
			$table->enum(column: TheTrace::TYPE, allowed: ['group', 'ability'])->comment(comment: '能力类型');
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
