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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('passenger_name');
            $table->enum('age_status', ['baby', 'adult', 'senior']);
            $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
            $table->string('bus_id'); // bus number or license plate
            $table->dateTime('departure_datetime');
            $table->string('ticket_code')->unique();
            $table->enum('ticket_status', ['created', 'confirmed'])->default('created');
            $table->foreignId('creator_user_id')->constrained('users')->onDelete('cascade');
            $table->decimal('tax', 8, 2)->nullable();
            $table->decimal('service_fee', 8, 2)->nullable();
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
