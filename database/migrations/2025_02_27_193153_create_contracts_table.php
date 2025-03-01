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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->Integer('user_id');
            $table->Integer('contractType');
            $table->date('startDate');
            $table->date('endDate');
            $table->decimal('salary', 8, 2);
            $table->enum('status', ['active', 'finished']);
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('contractType')->references('id')->on('contract_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
