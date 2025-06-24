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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->string('modele');
            $table->string('matricule');
            $table->year('annee_fabrication');
            $table->string('type_carburant');
            $table->integer('capacite_reservoir');
            $table->integer('kilometrage');
            $table->date('date_visite_technique');
            $table->date('date_expiration_assurance');
            $table->string('status');
            $table->date('date_achat');
            $table->softDeletes();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicules');
    }
};
