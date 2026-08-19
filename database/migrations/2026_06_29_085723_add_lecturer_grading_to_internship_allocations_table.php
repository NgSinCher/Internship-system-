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
        if (!Schema::hasColumn('internship_allocations', 'lecturer_score')) {
            $table->integer('lecturer_score')->nullable(); // 存老师的原始分
        }
        if (!Schema::hasColumn('internship_allocations', 'lecturer_feedback')) {
            $table->text('lecturer_feedback')->nullable(); // 老师评语
        }
        if (!Schema::hasColumn('internship_allocations', 'grade_status')) {
            $table->string('grade_status')->nullable();    // 及格状态
        }
        if (!Schema::hasColumn('internship_allocations', 'total_weighted_score')) {
            $table->decimal('total_weighted_score', 5, 2)->nullable(); // 终极加权分(支持86.50这种小数)
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
