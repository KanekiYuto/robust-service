<?php

use App\Cascade\Trace\Eloquent\Admin\LogTrace as TheTrace;
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
            $table->bigInteger(column: TheTrace::ID)->primary()->unique()->comment(comment: '管理员日志ID');
			$table->bigInteger(column: TheTrace::ADMIN_ID)->comment(comment: '管理员ID');
			$table->string(column: TheTrace::API, length: 128)->comment(comment: 'API名称');
			$table->ipAddress(column: TheTrace::IPADDRESS)->comment(comment: '请求IP');
			$table->json(column: TheTrace::PAYLOAD)->comment(comment: '请求荷载');
			$table->json(column: TheTrace::HEADERS)->comment(comment: '请求头');
			$table->json(column: TheTrace::RESPONSE)->comment(comment: '响应参数');
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
