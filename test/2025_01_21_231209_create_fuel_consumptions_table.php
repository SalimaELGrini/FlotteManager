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
        Schema::create('fuel_consumptions', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للسجل
            $table->unsignedBigInteger('vehicule_id'); // معرف المركبة
            $table->decimal('fuel_added', 8, 2); // كمية الوقود المضافة
            $table->date('date_fuel_added'); // تاريخ إضافة الوقود
            $table->decimal('fuel_price_per_liter', 8, 2); // سعر الوقود لكل لتر
            $table->decimal('total_cost', 10, 2); // التكلفة الإجمالية للوقود
            $table->string('station_service')->nullable(); // اسم محطة الوقود
            $table->decimal('distance_parcourue', 10, 2)->nullable(); // المسافة المقطوعة بالكيلومترات
            $table->decimal('fuel_efficiency', 10, 2)->nullable(); // كفاءة الوقود (كم/لتر)
            $table->text('commentaire')->nullable(); // ملاحظات إضافية
            $table->timestamps(); // تاريخ الإنشاء والتحديث

            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade'); // الربط بجدول المركبات
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
