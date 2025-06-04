<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tx_ref')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 5)->default('ETB');
            $table->string('payment_gateway')->default('chapa'); // chapa, stripe, etc
            $table->string('payment_method')->nullable(); // telebirr, cbe birr, etc
            $table->string('level'); // mewucha, ticket, etc
            $table->foreignId('schedule_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, paid, failed
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
