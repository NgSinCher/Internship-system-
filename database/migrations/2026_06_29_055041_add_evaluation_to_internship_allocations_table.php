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
        
        // 1. 如果没有 rubric_scores，才创建
        if (!Schema::hasColumn('internship_allocations', 'rubric_scores')) {
            $table->json('rubric_scores')->nullable();
        }

        // 2. 如果没有 final_score，才创建（刚好把刚才报错的地方完美避开！）
        if (!Schema::hasColumn('internship_allocations', 'final_score')) {
            $table->integer('final_score')->nullable();
        }

        // 3. 如果没有 final_comments，才创建
        if (!Schema::hasColumn('internship_allocations', 'final_comments')) {
            $table->text('final_comments')->nullable();
        }

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
