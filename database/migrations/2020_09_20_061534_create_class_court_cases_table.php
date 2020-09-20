<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassCourtCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_court_cases', function (Blueprint $table) {
            $table->bigIncrements('Cases_id');
            $table->integer('DataCus_id')->nullable();     //P-Key
            $table->string('DateDeed')->nullable();        //วันที่คัดโฉนด
            $table->string('NoteDocCase')->nullable();     //หมายเหตุ
            $table->string('seizure')->nullable();         //ตั้งเรื่องยึดทรัพย์
            $table->string('Selling')->nullable();         //ค่าใช้จ่าย
            $table->string('resultsSell')->nullable();     //ผลประกาศขายได้
            $table->string('Datesoldout')->nullable();     //วันที่ขายได้  
            $table->string('AmountSell')->nullable();      //จำนวนเงิน

            $table->string('DatePrice')->nullable();      //วันที่จ่ายเงิน
            $table->string('CountSelling')->nullable();      //จำนวนประกาศขาย
            $table->string('Cashpay')->nullable();           //เงินที่จ่าย

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
        Schema::dropIfExists('class_court_cases');
    }
}
