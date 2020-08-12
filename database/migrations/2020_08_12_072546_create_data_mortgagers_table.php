<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataMortgagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_mortgagers', function (Blueprint $table) {
            $table->bigIncrements('Mortgager_id');
            $table->integer('DataCus_id')->nullable();           //P-Key
            $table->string('Name_Mortgager')->nullable();        //ชื่อ-นามสกุล
            $table->string('Address_Mortgager')->nullable();     //ที่อยู่
            $table->string('NumberDeed_Mortgager')->nullable();  //เลขที่โฉนด
            $table->string('NameUser')->nullable();              //ชื่อผู้ใช้งาน
            $table->date('DateUser')->nullable();                //วันที่คีย์ข้อมูล
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
        Schema::dropIfExists('data_mortgagers');
    }
}
