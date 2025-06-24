<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeInterventionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('type_interventions', function (Blueprint $table) {
            $table->id(); // ID unique li kay7ddid type intervention
            $table->string('name'); // Smiyt type dial intervention
            $table->text('description')->nullable(); // Wasf ltype dial intervention
            $table->timestamps(); // Date tkhll9 wa ttsawer
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_interventions');
    }
}
