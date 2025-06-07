<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class AlterTicketStatusEnumOnTicketsTable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE tickets MODIFY ticket_status ENUM('created', 'confirmed', 'cancelled', 'refunded') NOT NULL DEFAULT 'created'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE tickets MODIFY ticket_status ENUM('created', 'confirmed') NOT NULL DEFAULT 'created'");
    }
}
