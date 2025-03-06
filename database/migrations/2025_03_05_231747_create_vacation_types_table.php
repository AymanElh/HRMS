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
        Schema::create('vacation_types', function (Blueprint $table) {
            $table->id();
            $table->integer('base_annual_days')->default(18);
            $table->decimal('days_per_month_before_year', 3, 2)->default(1.5);
            $table->decimal('days_per_year', 3, 2)->default(0.5);
            $table->integer('min_notice_days')->default(7);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacation_types');
    }
};
