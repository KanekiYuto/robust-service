<?php

use App\Models\Traces\Admin\Log as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理员日志
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
            $table->bigInteger(TheTrace::ID)->primary()->unique()->comment('管理员日志ID');
            $table->bigInteger(TheTrace::ADMIN_ID)->comment('管理员ID');
            $table->string(TheTrace::API, 128)->comment('API名称');
            $table->json(TheTrace::PAYLOAD)->comment('请求荷载');
            $table->json(TheTrace::HEADERS)->comment('请求头');
            $table->json(TheTrace::RESPONSE)->comment('响应参数');
            $table->ipAddress(TheTrace::IPADDRESS)->comment('请求IP');
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
