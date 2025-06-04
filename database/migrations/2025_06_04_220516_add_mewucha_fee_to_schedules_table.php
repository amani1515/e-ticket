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
        $table->decimal('mewucha_fee', 10, 2)->nullable()->after('departed_by');
    });
}

public function down()
{
    Schema::table('schedules', function (Blueprint $table) {
        $table->dropColumn('mewucha_fee');
    });
}

};
