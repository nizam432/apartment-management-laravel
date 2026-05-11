<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create flats table.
     */
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('floor_id')->constrained()->onDelete('cascade');
            $table->foreignId('owner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('flat_number');
            $table->string('flat_type')->nullable();
            $table->decimal('size_sqft', 10, 2)->nullable();
            $table->decimal('rent_amount', 10, 2)->default(0);
            $table->boolean('water_bill_applicable')->default(false);
            $table->decimal('water_bill_amount', 10, 2)->nullable();
            $table->enum('electricity_type', ['prepaid', 'postpaid'])->default('prepaid');
            $table->string('electricity_meter_no')->nullable();
            $table->enum('status', ['vacant', 'occupied'])->default('vacant');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};