<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->string('driver_name')->nullable()->change();
            $table->string('driver_phone')->nullable()->change();
            $table->string('redat_name')->nullable()->change();
            $table->enum('level', ['level1', 'level2', 'level3'])->nullable()->change();
            $table->string('model_year')->nullable()->change();
            $table->string('model')->nullable()->change();
            $table->string('bolo_id')->nullable()->change();
            $table->string('motor_number')->nullable()->change();
            $table->string('color')->nullable()->change();
            $table->foreignId('owner_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->string('driver_name')->nullable(false)->change();
            $table->string('driver_phone')->nullable(false)->change();
            $table->string('redat_name')->nullable(false)->change();
            $table->enum('level', ['level1', 'level2', 'level3'])->nullable(false)->change();
            $table->string('model_year')->nullable(false)->change();
            $table->string('model')->nullable(false)->change();
            $table->string('bolo_id')->nullable(false)->change();
            $table->string('motor_number')->nullable(false)->change();
            $table->string('color')->nullable(false)->change();
            $table->foreignId('owner_id')->nullable(false)->change();
        });
    }
};