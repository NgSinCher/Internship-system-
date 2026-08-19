<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_allocations', function (Blueprint $table) {
            $table->integer('final_score')->nullable()->after('lecturer_sv_id'); // 存总分（0-100）
            $table->text('lecturer_feedback')->nullable()->after('final_score'); // 讲师评语
            $table->enum('grade_status', ['in_progress', 'passed', 'failed'])->default('in_progress')->after('lecturer_feedback'); // 及格状态
        });
    }

    public function down(): void
    {
        Schema::table('internship_allocations', function (Blueprint $table) {
            $table->dropColumn(['final_score', 'lecturer_feedback', 'grade_status']);
        });
    }
};