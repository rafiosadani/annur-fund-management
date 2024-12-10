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
        Schema::create('t_expenses', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('m_fundraising_program_id', 36)->nullable();
            $table->string('expense_code', 36)->unique()->nullable();
            $table->string('title')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->enum('type', ['general', 'program'])->default('general');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->foreign('m_fundraising_program_id')->references('id')->on('m_fundraising_programs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_expenses');
    }
};
