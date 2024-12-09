<?php

use App\Cascade\Trace\Eloquent\AdminRole\AbilityTrace as TheTrace;
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
            $table->bigInteger(column: TheTrace::ID)->primary()->unique()->comment(comment: '角色能力 - [ID]');
			$table->bigInteger(column: TheTrace::ROLE_ID)->comment(comment: '角色 - [ID]');
			$table->bigInteger(column: TheTrace::ABILITY_ID)->comment(comment: '能力 - [ID]');
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
