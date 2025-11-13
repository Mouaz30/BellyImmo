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
        Schema::create('bien_immobiliers', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->decimal('prix', 12, 2);
            $table->string('adresse');
            $table->string('type'); 
            $table->text('description')->nullable();
            $table->string('statut')->default('disponible'); 
            $table->foreignId('proprietaire_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bien_immobiliers');
    }
};
