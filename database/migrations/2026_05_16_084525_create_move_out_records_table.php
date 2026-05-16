<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('move_out_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('floor_id')->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->decimal('advance_paid', 10, 2)->default(0);
            $table->decimal('amount_returned', 10, 2)->default(0);
            $table->decimal('deduction', 10, 2)->default(0);
            $table->text('deduction_reason')->nullable();
            $table->date('move_out_date');
            $table->text('reason')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('move_out_records');
    }
};