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
                $table->integer('capacity')->nullable(); // Will be set from bus
                $table->integer('boarding')->default(0); // Number of tickets sold
            });
        }

        public function down()
        {
            Schema::table('schedules', function (Blueprint $table) {
                $table->dropColumn(['capacity', 'boarding']);
            });
        }
};
