<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->string('cargo_uid')->unique();
            $table->unsignedBigInteger('bus_id');
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('destination_id');
            $table->unsignedBigInteger('measured_by');
            $table->float('weight');
            $table->decimal('service_fee', 10, 2);
            $table->decimal('tax', 10, 2);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', ['measured', 'paid', 'loaded'])->default('measured');
            $table->timestamps();

            $table->foreign('bus_id')->references('id')->on('buses');
            $table->foreign('schedule_id')->references('id')->on('schedules');
            $table->foreign('destination_id')->references('id')->on('destinations');
            $table->foreign('measured_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cargos');
    }
};