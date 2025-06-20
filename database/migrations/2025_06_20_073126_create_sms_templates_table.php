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
    Schema::create('sms_templates', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // e.g. 'Second Queued Bus', 'Mahberat Notification'
        $table->string('type'); // e.g. 'bus', 'mahberat', 'user', 'balehabt'
        $table->text('content'); // e.g. 'Bus {{targa}} is now second in queue...'
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_templates');
    }
};
