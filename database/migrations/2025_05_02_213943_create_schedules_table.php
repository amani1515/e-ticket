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
    Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
        $table->foreignId('destination_id')->constrained('destinations')->onDelete('cascade');
        $table->foreignId('scheduled_by')->constrained('users')->onDelete('cascade'); // current user
        $table->timestamp('scheduled_at')->nullable(); // optional: when scheduled
        $table->enum('status', ['queued', 'departed', 'cancelled'])->default('queued'); // queue status
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
