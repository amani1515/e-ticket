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
       DB::statement("ALTER TABLE buses MODIFY status ENUM(
            'active', 
            'maintenance', 
            'out_of_service', 
            'bolo_expire',
            'accident',
            'gidaj_yeweta',
            'not_paid',
            'punished',
            'driver_shortage'
        ) DEFAULT 'active'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE buses MODIFY status ENUM(
            'active', 
            'maintenance', 
            'out_of_service', 
            'bolo_expire',
            'accident',
            'gidaj_yeweta',
            'not_paid',
            'punished',
            'driver_shortage'
        ) DEFAULT 'active'");
    }
};
