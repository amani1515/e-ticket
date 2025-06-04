<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->enum('disability_status', [
                'None',
                'Blind / Visual Impairment',
                'Deaf / Hard of Hearing',
                'Speech Impairment'
            ])->default('None')->after('age_status');
        });
    }

    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('disability_status');
        });
    }
};
