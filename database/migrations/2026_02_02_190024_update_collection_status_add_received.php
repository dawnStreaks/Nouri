<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE material_transfer_requests MODIFY COLUMN collection_status ENUM('pending', 'ready_for_collection', 'collected', 'received', 'completed') DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE material_transfer_requests MODIFY COLUMN collection_status ENUM('pending', 'ready_for_collection', 'collected', 'completed') DEFAULT 'pending'");
    }
};
