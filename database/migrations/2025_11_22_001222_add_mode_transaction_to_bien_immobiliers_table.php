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
        Schema::table('bien_immobiliers', function (Blueprint $table) {
            $table->string('mode_transaction')->default('location');
        });
    }

    public function down()
    {
        Schema::table('bien_immobiliers', function (Blueprint $table) {
            $table->dropColumn('mode_transaction');
        });
    }

};
