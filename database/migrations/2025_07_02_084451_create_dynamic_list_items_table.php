<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dynamic_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dynamic_list_id')->constrained()->onDelete('cascade');
            $table->string('label'); // اسم البند
            $table->integer('order')->default(0); // للترتيب
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dynamic_list_items');
    }
};
