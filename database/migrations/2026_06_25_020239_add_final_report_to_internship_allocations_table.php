<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('internship_allocations', function (Blueprint $table) {
            $table->string('final_report_path')->nullable()->after('grade_status'); // 存 PDF 文件路径
        });
    }

    public function down(): void
    {
        Schema::table('internship_allocations', function (Blueprint $table) {
            $table->dropColumn('final_report_path');
        });
    }
};