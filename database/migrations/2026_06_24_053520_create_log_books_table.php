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
        Schema::create('log_books', function (Blueprint $table) {
            $table->id();
            
            // 极其核心：绑定到分配表
            $table->foreignId('internship_allocation_id')->constrained('internship_allocations')->onDelete('cascade');
            
            $table->date('date');                           // 日期
            $table->text('activity_description');           // 今天写了什么代码
            $table->decimal('working_hours', 4, 1)->default(8.0); // 工作时长（如 8.0 小时）
            
            // 状态审核：pending(待老板批)、approved(已批准)、rejected(被退回重写)
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            
            $table->text('supervisor_remarks')->nullable(); // 老板如果退回，在这里写骂人的原因
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_books');
    }
};
