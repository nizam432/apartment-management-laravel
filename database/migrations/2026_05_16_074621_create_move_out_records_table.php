<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    /**
     * Create move_out_records table.
     * Tracks tenant move out details including security deposit return.
     */
    public function up(): void
    {
        Schema::create('move_out_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('flat_id')->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->decimal('advance_paid', 10, 2)->default(0);    // How much advance was paid
            $table->decimal('amount_returned', 10, 2)->default(0); // How much was returned
            $table->decimal('deduction', 10, 2)->default(0);       // How much was deducted
            $table->string('deduction_reason')->nullable();         // Reason for deduction
            $table->date('move_in_date');
            $table->date('move_out_date');
            $table->string('reason')->nullable();                   // Reason for moving out
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('move_out_records');
    }
};