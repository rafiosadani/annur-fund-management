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
        Schema::create('t_good_donations', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('m_user_id', 36)->nullable();
            $table->string('m_good_inventory_id', 36)->nullable();
            $table->string('good_donation_code', 36)->unique()->nullable();
            $table->integer('quantity')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();

            $table->foreign('m_user_id')->references('id')->on('m_users')->onDelete('set null');
            $table->foreign('m_good_inventory_id')->references('id')->on('m_good_inventories')->onDelete('set null');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_goods');
    }
};
