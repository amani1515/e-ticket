<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxAndServiceFeeToCashReportsTable extends Migration
{
    public function up()
    {
        Schema::table('cash_reports', function (Blueprint $table) {
            $table->decimal('tax', 10, 2)->default(0)->after('total_amount');
            $table->decimal('service_fee', 10, 2)->default(0)->after('tax');
        });
    }

    public function down()
    {
        Schema::table('cash_reports', function (Blueprint $table) {
            $table->dropColumn(['tax', 'service_fee']);
        });
    }
}
