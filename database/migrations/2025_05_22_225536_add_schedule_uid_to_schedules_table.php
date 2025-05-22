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
    Schema::table('schedules', function ($table) {
        $table->string('schedule_uid')->nullable()->after('id');
    });
}

public function down()
{
    Schema::table('schedules', function ($table) {
        $table->dropColumn('schedule_uid');
    });
}
};
