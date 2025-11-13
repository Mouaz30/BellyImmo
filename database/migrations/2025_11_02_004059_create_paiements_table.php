<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->string('methode');        // OM, WAVE, ESPECES, CB
            $table->string('statut');         // EN_ATTENTE, PAYE, ECHEC
            $table->unsignedBigInteger('reservation_id')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('vente_id')->nullable();
            $table->timestamps();

            // Clés étrangères
            $table->foreign('reservation_id')->references('id')->on('reservations')->cascadeOnDelete();
            $table->foreign('location_id')->references('id')->on('locations')->cascadeOnDelete();
            $table->foreign('vente_id')->references('id')->on('ventes')->cascadeOnDelete();
        });

        // CHECK : exactement une des trois colonnes doit être renseignée
        DB::statement('
            ALTER TABLE paiements
            ADD CONSTRAINT chk_one_source
            CHECK (
                (
                    (reservation_id IS NOT NULL) +
                    (location_id    IS NOT NULL) +
                    (vente_id       IS NOT NULL)
                ) = 1
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
