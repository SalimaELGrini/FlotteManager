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
        Schema::create('fuel_consumptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicule_id')->constrained('vehicules')->onDelete('cascade');
            $table->decimal('fuel_added', 8, 2);
            $table->date('date_fuel_added');
            $table->decimal('fuel_price_per_liter', 8, 2);
            $table->decimal('total_cost', 10, 2);
            $table->string('station_service')->nullable();
            $table->decimal('distance_parcourue', 10, 2)->nullable();
            $table->decimal('fuel_efficiency', 10, 2)->nullable();
            $table->text('commentaire')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_consumptions');
    }
};
