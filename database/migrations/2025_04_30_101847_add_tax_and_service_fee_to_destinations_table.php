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
    Schema::table('destinations', function (Blueprint $table) {
        $table->decimal('tax', 8, 2)->nullable();
        $table->decimal('service_fee', 8, 2)->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['tax', 'service_fee']);
        });
    }
};
