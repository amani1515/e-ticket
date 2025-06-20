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
    Schema::create('sms_messages', function (Blueprint $table) {
        $table->id();
        $table->string('to'); // phone number
        $table->text('message');
        $table->string('status')->default('pending'); // pending, sent, failed
        $table->string('template_name')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_messages');
    }
};
