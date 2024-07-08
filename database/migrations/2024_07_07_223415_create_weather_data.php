<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->float('temperature', 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
