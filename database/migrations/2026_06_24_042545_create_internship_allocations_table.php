<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('internship_allocations', function (Blueprint $table) {
            $table->id();
            // 1. 绑定的学生 ID (连结到 users 表)
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            
            // 2. 去的实习公司 ID (连结到 companies 表)
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            
            // 3. 业界主管 ID (连结到 users 表)
            $table->foreignId('company_sv_id')->constrained('users')->onDelete('cascade');
            
            // 4. 学校监督讲师 ID (连结到 users 表)
            $table->foreignId('lecturer_sv_id')->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internship_allocations');
    }
};
