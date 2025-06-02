<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Modify the ENUM to add 'middle_aged'
        DB::statement("ALTER TABLE tickets MODIFY COLUMN age_status ENUM('baby', 'adult', 'middle_aged', 'senior')");
    }

    public function down(): void
    {
        // Revert the ENUM back to original
        DB::statement("ALTER TABLE tickets MODIFY COLUMN age_status ENUM('baby', 'adult', 'senior')");
    }
};
