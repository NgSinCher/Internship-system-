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
    Schema::create('companies', function (Blueprint $table) {
        $table->id();
        $table->string('name');             // Companies name
        $table->string('company_number');   // Companies ID
        $table->text('address');            // Address
        $table->string('phone');            // Phone
        $table->string('person_in_charge'); // Person in charge
        $table->string('photo')->nullable();// Photo 照片路径（暂时允许空白）
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
