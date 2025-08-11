<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add sync fields to users table
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to destinations table
        Schema::table('destinations', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to tickets table
        Schema::table('tickets', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to cash_reports table
        Schema::table('cash_reports', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to buses table
        Schema::table('buses', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to schedules table
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to mahberats table
        Schema::table('mahberats', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Add sync fields to cargos table
        Schema::table('cargos', function (Blueprint $table) {
            $table->string('uuid', 50)->unique()->nullable()->after('id');
            $table->boolean('synced')->default(false)->after('updated_at');
            $table->timestamp('synced_at')->nullable()->after('synced');
            $table->timestamp('last_modified')->useCurrent()->useCurrentOnUpdate()->after('synced_at');
        });

        // Create sync_queue table
        Schema::create('sync_queue', function (Blueprint $table) {
            $table->id();
            $table->string('model_type', 100);
            $table->unsignedBigInteger('model_id');
            $table->string('model_uuid', 50);
            $table->enum('action', ['create', 'update', 'delete']);
            $table->json('data');
            $table->boolean('synced')->default(false);
            $table->integer('retry_count')->default(0);
            $table->timestamp('last_attempt')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index(['synced', 'retry_count']);
            $table->index(['model_type', 'model_id']);
        });

        // Create sync_settings table
        Schema::create('sync_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->text('value');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('cash_reports', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('buses', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('mahberats', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::table('cargos', function (Blueprint $table) {
            $table->dropColumn(['uuid', 'synced', 'synced_at', 'last_modified']);
        });

        Schema::dropIfExists('sync_queue');
        Schema::dropIfExists('sync_settings');
    }
};