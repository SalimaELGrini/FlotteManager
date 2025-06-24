<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterventionsTable extends Migration
{
    public function up()
    {
        Schema::create('interventions', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للتدخل
            $table->unsignedBigInteger('vehicule_id'); // معرف المركبة
            $table->unsignedBigInteger('type_intervention_id'); // نوع التدخل
            $table->unsignedBigInteger('panne_id')->nullable(); // معرف العطل المرتبط (اختياري)
            $table->unsignedBigInteger('garage_id')->nullable(); // معرف الكراج (اختياري)
            $table->text('description')->nullable(); // وصف التدخل
            $table->date('date_intervention'); // تاريخ التدخل
            $table->time('duration')->nullable(); // مدة التدخل
            $table->text('parts_used')->nullable(); // قطع الغيار المستخدمة
            $table->decimal('total_cost', 10, 2)->nullable(); // التكلفة الإجمالية
            $table->string('nom_technician', 255)->nullable(); // اسم الفني المسؤول
            $table->timestamps(); // تاريخ الإنشاء والتحديث

            // العلاقات
            $table->foreign('vehicule_id')->references('id')->on('vehicules')->onDelete('cascade');
            $table->foreign('type_intervention_id')->references('id')->on('type_interventions')->onDelete('cascade');
            $table->foreign('panne_id')->references('id')->on('pannes')->onDelete('set null');
            $table->foreign('garage_id')->references('id')->on('garages')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interventions');
    }
}
