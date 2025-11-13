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
        Schema::create('locations', function (Blueprint $table) {
            $table->id(); // idLocation
            $table->date('date_debut');
            $table->decimal('loyer_mensuel', 10, 2);
            $table->decimal('caution', 10, 2);
            $table->string('statut')->default('actif'); // ACTIF, PREAVIS, EXPIRE
            $table->foreignId('bien_immobilier_id')->constrained();
            $table->foreignId('client_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
