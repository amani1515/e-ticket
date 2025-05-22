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
        $table->unsignedBigInteger('paid_by')->nullable()->after('status');
        $table->timestamp('paid_at')->nullable()->after('paid_by');
        $table->unsignedBigInteger('departed_by')->nullable()->after('paid_at');
        $table->timestamp('departed_at')->nullable()->after('departed_by');
    });
}

public function down()
{
    Schema::table('schedules', function ($table) {
        $table->dropColumn(['paid_by', 'paid_at', 'departed_by', 'departed_at']);
    });
}
};
