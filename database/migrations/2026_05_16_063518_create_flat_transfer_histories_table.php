<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create flat_transfer_histories table.
     * Tracks tenant flat transfers within the same building.
     */
    public function up(): void
    {
        Schema::create('flat_transfer_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_flat_id')->constrained('flats')->onDelete('cascade');
            $table->foreignId('to_flat_id')->constrained('flats')->onDelete('cascade');
            $table->foreignId('from_floor_id')->constrained('floors')->onDelete('cascade');
            $table->foreignId('to_floor_id')->constrained('floors')->onDelete('cascade');
            $table->decimal('old_rent', 10, 2);
            $table->decimal('new_rent', 10, 2);
            $table->date('transfer_date');
            $table->string('reason')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flat_transfer_histories');
    }
};