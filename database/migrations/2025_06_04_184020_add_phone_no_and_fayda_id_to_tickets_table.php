<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('phone_no')->nullable()->after('schedule_id'); // adjust 'id' to a relevant column
            $table->string('fayda_id')->nullable()->after('phone_no');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['phone_no', 'fayda_id']);
        });
    }
};
