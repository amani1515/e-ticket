<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('buses', function (Blueprint $table) {
        $table->id();
        $table->string('targa');
        $table->string('driver_name');
        $table->string('driver_phone');
        $table->string('redat_name');
        $table->enum('level', ['level1', 'level2', 'level3']);
        $table->integer('total_seats');
        $table->enum('status', ['active', 'maintenance', 'out_of_service'])->default('active');
        $table->string('model_year');
        $table->string('model');
        $table->string('bolo_id');
        $table->string('motor_number');
        $table->string('color');
        $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
        $table->string('file1')->nullable();
        $table->string('file2')->nullable();
        $table->string('file3')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buses');
    }
};
