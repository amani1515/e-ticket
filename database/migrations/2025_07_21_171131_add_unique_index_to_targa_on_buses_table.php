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
        $table->unique('targa');
    });
}

public function down()
{
    Schema::table('buses', function (Blueprint $table) {
        $table->dropUnique(['targa']);
    });
}
};
