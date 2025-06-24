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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('telephone');
            $table->string('numero_permis')->unique();
            $table->string('type_permis');
            $table->date('date_expiration_permis');
            $table->string('adresse');
            $table->date('date_embauche');
            $table->string('contact_urgence');
            $table->enum('status', ['disponible', 'occupe', 'en pause', 'non disponible']);
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
