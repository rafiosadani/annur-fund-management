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
        Schema::create('t_infaqs', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('m_infaq_type_id', 36)->nullable();
            $table->string('infaq_code', 36)->unique()->nullable();
            $table->string('name')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->timestamps();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->foreign('m_infaq_type_id')->references('id')->on('m_infaq_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_infaqs');
    }
};
