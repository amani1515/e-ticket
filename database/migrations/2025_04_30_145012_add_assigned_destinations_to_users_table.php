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
    Schema::table('users', function (Blueprint $table) {
        $table->json('assigned_destinations')->nullable(); // or use ->text() if you prefer CSV
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('assigned_destinations');
    });
}

};
