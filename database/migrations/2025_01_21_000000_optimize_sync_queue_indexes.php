<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('sync_queue', function (Blueprint $table) {
            // Add indexes for better sync performance
            $table->index(['synced', 'created_at'], 'idx_sync_status');
            $table->index(['retry_count', 'last_attempt'], 'idx_retry_status');
            $table->index('model_type', 'idx_model_type');
        });
    }

    public function down()
    {
        Schema::table('sync_queue', function (Blueprint $table) {
            $table->dropIndex('idx_sync_status');
            $table->dropIndex('idx_retry_status');
            $table->dropIndex('idx_model_type');
        });
    }
};