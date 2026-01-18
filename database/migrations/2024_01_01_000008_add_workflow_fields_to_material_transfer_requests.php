<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('material_transfer_requests', function (Blueprint $table) {
            $table->string('transfer_voucher_number')->nullable()->after('company_name');
            $table->enum('collection_status', ['pending', 'collected', 'completed'])->default('pending')->after('approved_at');
            $table->timestamp('collected_at')->nullable()->after('collection_status');
            $table->string('collected_by')->nullable()->after('collected_at');
        });
    }

    public function down(): void
    {
        Schema::table('material_transfer_requests', function (Blueprint $table) {
            $table->dropColumn(['transfer_voucher_number', 'collection_status', 'collected_at', 'collected_by']);
        });
    }
};