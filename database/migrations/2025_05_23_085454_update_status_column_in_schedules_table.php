<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE schedules MODIFY status ENUM('queued','on loading','full','departed','cancelled','paid','wellgo') NOT NULL DEFAULT 'queued'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous ENUM values
        DB::statement("ALTER TABLE schedules MODIFY status ENUM('queued','on loading','full','departed','cancelled','paid') NOT NULL DEFAULT 'queued'");
    }
};
