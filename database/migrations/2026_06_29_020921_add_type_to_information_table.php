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
        // 🌟 检查如果表里还没有 type 字段，就加上
        if (!Schema::hasColumn('information', 'type')) {
            Schema::table('information', function (Blueprint $table) {
                $table->string('type')->default('info')->after('content');
            });
        }
    } // 🌟 修复：刚才这里少了一个关闭 up 方法的大括号！

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('information', function (Blueprint $table) {
            // 如果回滚迁移，就删掉 type 字段
            if (Schema::hasColumn('information', 'type')) {
                $table->dropColumn('type');
            }
        });
    }
};