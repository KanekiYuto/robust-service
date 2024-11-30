<?php

use App\Trace\Eloquent\Admin\InfoTrace as TheTrace;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Database Migration [管理员信息表]
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
            $table->string(column: TheTrace::ID)->primary()->unique()->comment(comment: '管理员ID');
			$table->string(column: TheTrace::ACCOUNT, length: 32)->comment(comment: '账号');
			$table->string(column: TheTrace::ADMIN_ROLE_ID)->index()->comment(comment: '角色ID');
			$table->string(column: TheTrace::EMAIL, length: 32)->comment(comment: '邮箱');
			$table->string(column: TheTrace::PASS, length: 512)->comment(comment: '密码');
			$table->string(column: TheTrace::CREATED_AT)->comment(comment: '创建时间');
			$table->string(column: TheTrace::UPDATED_AT)->comment(comment: '修改时间');
			$table->string(column: TheTrace::TEST)->charset(charset: '111')->after(column: TheTrace::ID)->change();
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
