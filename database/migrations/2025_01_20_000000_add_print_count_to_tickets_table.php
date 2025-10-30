<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->integer('print_count')->default(0)->after('ticket_status');
            $table->timestamp('first_printed_at')->nullable()->after('print_count');
            $table->timestamp('last_printed_at')->nullable()->after('first_printed_at');
        });
    }

    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['print_count', 'first_printed_at', 'last_printed_at']);
        });
    }
};