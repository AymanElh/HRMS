<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vacation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('total_days');
            $table->foreignId('manager_id')->nullable()->references('id')->on('employees')->onDelete('cascade');
            $table->timestamp('manager_validated_at')->nullable();
            $table->foreignId('hr_id')->nullable()->references('id')->on('employees')->onDelete('cascade');
            $table->timestamp('hr_validated_at')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected', 'manager_approved', 'hr_approved', 'manager_rejected', 'hr_rejected'])->default('pending');
            $table->text('hr_comments')->nullable();
            $table->text('manager_comments')->nullable();
            $table->text('execuse')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacation_requests');
    }
};
