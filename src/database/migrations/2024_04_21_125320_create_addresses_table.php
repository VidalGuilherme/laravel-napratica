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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained();
            $table->string('zipcode', 8);
            $table->string('street');
            $table->string('number', 40);
            $table->string('complement')->nullable();
            $table->string('district', 60);
            $table->string('reference_point')->nullable();
            $table->foreignId('city_id')->constrained();
            $table->boolean('condominium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['city_id']);
            $table->dropForeign(['supplier_id']);
        });
        Schema::dropIfExists('addresses');
    }
};
