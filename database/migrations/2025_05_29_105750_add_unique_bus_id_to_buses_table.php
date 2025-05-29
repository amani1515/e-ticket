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
    Schema::table('buses', function (Blueprint $table) {
        $table->string('unique_bus_id')->unique()->nullable()->after('id');
    });
}

public function down()
{
    Schema::table('buses', function (Blueprint $table) {
        $table->dropColumn('unique_bus_id');
    });
}
};
