<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSuretysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_suretys', function (Blueprint $table) {
            $table->bigIncrements('Surety_id');
            $table->integer('DataCus_id')->nullable();     //P-Key
            $table->string('Name_Surety')->nullable();     //ชื่อ-นามสกุล
            $table->string('Address_Surety')->nullable();  //ที่อยู่
            $table->string('NameUser')->nullable();        //ชื่อผู้ใช้งาน
            $table->date('DateUser')->nullable();          //วันที่คีย์ข้อมูล
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_suretys');
    }
}
