<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('prenom')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telephone', 20)->nullable();
            $table->string('role')->default('client');
            $table->string('statut')->default('actif');
            $table->rememberToken();
            $table->timestamps();

            
            $table->softDeletes();

            $table->index(['role', 'statut']);
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
