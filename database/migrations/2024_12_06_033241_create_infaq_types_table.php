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
        Schema::create('m_infaq_types', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('infaq_type_code', 36)->unique()->nullable();
            $table->string('type_name')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_infaq_types');
    }
};
