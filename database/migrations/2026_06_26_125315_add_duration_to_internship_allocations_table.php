<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('internship_allocations', function (Blueprint $table) {
        $table->string('duration')->nullable(); // 添加 duration 字段
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('internship_allocations', function (Blueprint $table) {
            //
        });
    }
};
