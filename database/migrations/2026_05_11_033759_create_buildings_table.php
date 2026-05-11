<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Create buildings table.
     */
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('city');
            $table->string('area')->nullable();
            $table->integer('total_floors')->default(1);
            $table->integer('total_units')->default(0);
            $table->enum('electricity_type', ['prepaid', 'postpaid'])->default('prepaid');
            $table->boolean('water_bill_applicable')->default(false);
            $table->decimal('water_bill_amount', 10, 2)->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};