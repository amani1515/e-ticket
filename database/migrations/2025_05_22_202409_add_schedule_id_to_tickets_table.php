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
    Schema::table('tickets', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->unsignedBigInteger('schedule_id')->nullable()->after('id');
        $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('tickets', function (Illuminate\Database\Schema\Blueprint $table) {
        $table->dropForeign(['schedule_id']);
        $table->dropColumn('schedule_id');
    });
}
};
