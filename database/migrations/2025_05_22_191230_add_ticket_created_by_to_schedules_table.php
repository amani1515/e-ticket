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
    Schema::table('schedules', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->unsignedBigInteger('ticket_created_by')->nullable()->after('scheduled_by');
    });
}

public function down()
{
    Schema::table('schedules', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropColumn('ticket_created_by');
    });
}
};
