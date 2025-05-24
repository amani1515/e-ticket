<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cargo_settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('fee_per_km', 10, 2)->default(0);      // Cargo fee per kilometer
            $table->decimal('tax_percent', 5, 2)->default(0);      // Cargo tax percent
            $table->decimal('service_fee', 10, 2)->default(0);     // Cargo service fee
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargo_settings');
    }
};