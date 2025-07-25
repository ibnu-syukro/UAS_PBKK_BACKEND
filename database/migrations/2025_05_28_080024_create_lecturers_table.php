<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->string('lecturer_id')->primary();
            $table->string('name');
            $table->string('NIP');
            $table->string('department');
            $table->string('email');
            $table->timestamps();
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
