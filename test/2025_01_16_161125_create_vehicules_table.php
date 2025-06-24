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
        Schema::create('vehicules', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique();
            $table->string('modele');
            $table->string('matricule')->unique();
            $table->year('annee_fabrication');
            $table->string('type_carburant');
            $table->integer('capacite_reservoir');
            $table->integer('kilometrage');
            $table->date('date_visite_technique');
            $table->date('date_expiration_assurance');
            $table->string('status');
            $table->date('date_achat');
            $table->date('date_debut')->nullable(); // يمكنك تعديل النوع والقيمة الافتراضية حسب حاجتك
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
