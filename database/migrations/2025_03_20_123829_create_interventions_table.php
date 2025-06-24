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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained('vehicules')->onDelete('cascade');
            $table->foreignId('type_intervention_id')->constrained('type_interventions')->onDelete('cascade');
            $table->foreignId('panne_id')->nullable()->constrained('pannes')->onDelete('set null');
            $table->foreignId('garage_id')->nullable()->constrained('garages')->onDelete('set null');
            $table->text('description')->nullable();
            $table->date('date_intervention');
            $table->time('duration')->nullable();
            $table->text('parts_used')->nullable();
            $table->decimal('total_cost', 10, 2)->nullable();
            $table->string('nom_technician')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
