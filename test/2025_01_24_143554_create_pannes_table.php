<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePannesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pannes', function (Blueprint $table) {
            $table->id(); // ID l3tiraf l7adid dial panne
            $table->unsignedBigInteger('vehicule_id'); // ID dial lmakina li kat3ani mn panne
            $table->string('description'); // Wasf dial panne
            $table->date('date_panne'); // Tarikh dial panne
            $table->boolean('resolved')->default(false); // wach l7al li kayn fi panne rah l9it awla la
            $table->timestamps(); // Tarikh li tkhll9 wa ttsawer

            // Dir lrelation ma3a lmakina
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pannes');
    }
}
