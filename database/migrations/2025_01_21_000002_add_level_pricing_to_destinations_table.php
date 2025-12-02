<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->decimal('level1_tariff', 10, 2)->nullable()->after('tariff');
            $table->decimal('level2_tariff', 10, 2)->nullable()->after('level1_tariff');
            $table->decimal('level3_tariff', 10, 2)->nullable()->after('level2_tariff');
            $table->boolean('same_for_all_levels')->default(false)->after('level3_tariff');
        });
    }

    public function down()
    {
        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['level1_tariff', 'level2_tariff', 'level3_tariff', 'same_for_all_levels']);
        });
    }
};