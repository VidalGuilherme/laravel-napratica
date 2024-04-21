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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->enum('supplier_type', ['pf', 'pj']);
            $table->string('cpf', 11)->nullable();
            $table->string('personal_name')->nullable();
            $table->string('nickname', 11)->nullable();
            $table->string('rg', 11)->nullable();            
            $table->string('cnpj', 14)->nullable();            
            $table->string('company_name')->nullable();
            $table->string('fantasy_name')->nullable();
            $table->enum('state_indicator', ['contribuinte', 'contribuinte_insento', 'nao_contribuinte'])->nullable();
            $table->string('state_registration')->nullable();
            $table->string('municipal_registration')->nullable();
            $table->string('cnpj_status', 20)->nullable();
            $table->enum('retreat', ['recolher', 'retido'])->nullable();
            $table->boolean('active');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
