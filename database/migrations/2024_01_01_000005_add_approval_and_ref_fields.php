<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('material_transfer_requests', function (Blueprint $table) {
            $table->string('ref_no')->nullable()->after('transfer_route');
            $table->boolean('is_approved')->default(false)->after('rt');
            $table->string('approved_by')->nullable()->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    public function down(): void
    {
        Schema::table('material_transfer_requests', function (Blueprint $table) {
            $table->dropColumn(['ref_no', 'is_approved', 'approved_by', 'approved_at']);
        });
    }
};