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
    Schema::create('departure_fees', function (Blueprint $table) {
        $table->id();
        $table->enum('level', ['level1', 'level2', 'level3'])->unique();
        $table->decimal('fee', 10, 2)->default(0.00);
        $table->timestamps();
    });
}


    /**php artisan make:model DepartureFee

     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_fees');
    }
};
