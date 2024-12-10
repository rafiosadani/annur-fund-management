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
        Schema::create('m_good_inventories', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->string('good_inventory_code', 36)->unique()->nullable();
            $table->string('item_name')->nullable();
            $table->string('merk')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->string('created_by', 36)->nullable();
            $table->string('updated_by', 36)->nullable();
            $table->string('deleted_by', 36)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_good_inventories');
    }
};
