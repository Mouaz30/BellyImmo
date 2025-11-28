<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::create('visites', function (Blueprint $table) {
        $table->id();
        $table->foreignId('client_id')->constrained('users')->cascadeOnDelete();
        $table->foreignId('bien_immobilier_id')->constrained()->cascadeOnDelete();
        $table->date('date_visite');
        $table->time('heure_visite');
        $table->text('message')->nullable();
        $table->string('statut')->default('EN_ATTENTE');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visites');
    }
};
