<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCancelledAndRefundedAtToTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->timestamp('cancelled_at')->nullable()->after('ticket_status');
            $table->timestamp('refunded_at')->nullable()->after('cancelled_at');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('cancelled_at');
            $table->dropColumn('refunded_at');
        });
    }
}
