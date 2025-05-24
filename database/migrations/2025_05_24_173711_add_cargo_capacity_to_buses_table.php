<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->decimal('cargo_capacity', 8, 2)->nullable()->after('total_seats');
        });
    }

    public function down()
    {
        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn('cargo_capacity');
        });
    }
};