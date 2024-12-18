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
        Schema::create('m_donor_profiles', function (Blueprint $table) {
            $table->string('id', 36)->primary()->unique();
            $table->string('donor_profile_code', 36)->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['laki-laki', 'perempuan'])->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->boolean('is_anonymous')->default(0);
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
        Schema::dropIfExists('m_donor_profiles');
    }
};
