<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('transfer_status_logs')) {
            Schema::create('transfer_status_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('transfer_id')->constrained('material_transfer_requests')->onDelete('cascade');
                $table->enum('status', ['pending', 'requested', 'collected', 'completed']);
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index(['transfer_id', 'created_at']);
            });
        }

        Schema::table('material_transfer_requests', function (Blueprint $table) {
            if (!Schema::hasIndex('material_transfer_requests', 'mtr_route_status_idx')) {
                $table->index(['transfer_route', 'collection_status'], 'mtr_route_status_idx');
            }
            if (!Schema::hasIndex('material_transfer_requests', 'mtr_created_status_idx')) {
                $table->index(['created_at', 'collection_status'], 'mtr_created_status_idx');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_status_logs');
        Schema::table('material_transfer_requests', function (Blueprint $table) {
            $table->dropIndex('mtr_route_status_idx');
            $table->dropIndex('mtr_created_status_idx');
        });
    }
};