<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataCusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_cuses', function (Blueprint $table) {
            $table->bigIncrements('Cus_id');
            $table->string('Name_Cus')->nullable();     //ชื่อ-นามสกุล
            $table->string('Number_Cus')->nullable();   //เลขที่สัญญา
            $table->string('Cash_Cus')->nullable();     //จำนวนเงิน
            $table->string('Address_Cus')->nullable();  //ที่อยู่
            $table->string('Type_Cus')->nullable();     //ประเภทสัญญา
            
            $table->string('Status_Cus')->nullable();   //สถานะจบงาน
            $table->date('DateStatus_Cus')->nullable(); //วันที่สถานะ
            $table->string('NameUser')->nullable();     //ชื่อผู้ใช้งาน
            $table->date('DateUser')->nullable();       //วันที่คีย์ข้อมูล
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
        Schema::dropIfExists('data_cuses');
    }
}
