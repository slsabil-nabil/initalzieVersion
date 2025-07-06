<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agency_id')->constrained()->onDelete('cascade'); // ربط بالوكالة
            $table->string('name'); // اسم الفرع
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable(); // الموقع الجغرافي أو العنوان
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
