<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    \DB::statement("ALTER TABLE schedules MODIFY COLUMN status ENUM('queued', 'on loading', 'full', 'departed', 'cancelled', 'paid') NOT NULL DEFAULT 'queued'");
}

public function down()
{
    \DB::statement("ALTER TABLE schedules MODIFY COLUMN status ENUM('queued', 'on loading', 'full', 'departed', 'cancelled') NOT NULL DEFAULT 'queued'");
}
};
