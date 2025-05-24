<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->decimal('cargo_capacity', 8, 2)->nullable()->after('status');
            $table->decimal('cargo_used', 8, 2)->default(0)->after('cargo_capacity');
        });
    }

    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['cargo_capacity', 'cargo_used']);
        });
    }
};