<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create utility_bills table.
     */
    public function up(): void
    {
        Schema::create('utility_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->string('month');                           // Format: 2025-01
            $table->decimal('water_bill', 10, 2)->default(0);
            $table->decimal('electricity_bill', 10, 2)->default(0);
            $table->integer('previous_reading')->nullable();   // postpaid only
            $table->integer('current_reading')->nullable();    // postpaid only
            $table->integer('unit_used')->nullable();          // auto calculate
            $table->decimal('rate_per_unit', 10, 2)->nullable();
            $table->decimal('other_bill', 10, 2)->default(0);
            $table->string('other_bill_title')->nullable();    // Generator, Lift...
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->date('paid_date')->nullable();
            $table->enum('payment_method', ['cash', 'bkash', 'nagad', 'bank', 'other'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utility_bills');
    }
};