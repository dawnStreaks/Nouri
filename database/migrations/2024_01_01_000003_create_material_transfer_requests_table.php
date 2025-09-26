<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('material_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('sl_no');
            $table->string('part_no');
            $table->decimal('showroom_requirement', 10, 2);
            $table->string('unit');
            $table->decimal('allocatable_qty', 10, 2);
            $table->decimal('actual_qty_received', 10, 2)->default(0);
            $table->boolean('st')->default(false);
            $table->boolean('rt')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('material_transfer_requests');
    }
};