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
        Schema::create('m_fundraising_program_images', function (Blueprint $table) {
            $table->string('id', 36)->primary()->unique();
            $table->string('m_fundraising_program_id', 36)->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->foreign('m_fundraising_program_id')->references('id')->on('m_fundraising_programs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_fundraising_program_images');
    }
};
