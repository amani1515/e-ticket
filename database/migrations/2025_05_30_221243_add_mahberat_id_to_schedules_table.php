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
    Schema::table('schedules', function (Blueprint $table) {
        $table->unsignedBigInteger('mahberat_id')->nullable()->after('scheduled_by');

        // Optional: add a foreign key if you have a `mahberats` table
        // $table->foreign('mahberat_id')->references('id')->on('mahberats')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('schedules', function (Blueprint $table) {
        $table->dropColumn('mahberat_id');
    });
}

};
