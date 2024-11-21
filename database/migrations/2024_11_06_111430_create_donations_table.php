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
        Schema::create('t_donations', function (Blueprint $table) {
            $table->string('id', 36)->primary()->unique();
            $table->string('m_user_id', 36)->nullable();
            $table->string('m_donor_profile_id', 36)->nullable();
            $table->string('m_fundraising_program_id', 36)->nullable();
            $table->string('donation_code', 36)->unique()->nullable();
            $table->integer('amount')->nullable();
            $table->enum('payment_method', ['offline', 'online'])->default('offline');
            $table->string('poof_of_payment')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'rejected'])->default('pending');
            $table->timestamps();
            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->foreign('m_user_id')->references('id')->on('m_users');
            $table->foreign('m_fundraising_program_id')->references('id')->on('m_fundraising_programs');
            $table->foreign('m_donor_profile_id')->references('id')->on('m_donor_profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_donations');
    }
};
