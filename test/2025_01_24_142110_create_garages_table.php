<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Migration for Garages Table
class CreateGaragesTable extends Migration
{
    public function up()
    {
        Schema::create('garages', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للكراج
            $table->string('name'); // اسم الكراج
            $table->string('address'); // عنوان الكراج
            $table->string('phone')->nullable(); // رقم هاتف الكراج
            $table->string('email')->nullable(); // بريد الكراج الإلكتروني
            $table->string('specializations'); // بريد الكراج الإلكتروني
            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down()
    {
        Schema::dropIfExists('garages');
    }
}
