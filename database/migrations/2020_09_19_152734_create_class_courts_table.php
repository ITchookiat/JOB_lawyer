<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_courts', function (Blueprint $table) {
            $table->bigIncrements('Court_id');
            $table->integer('DataCus_id')->nullable();     //P-Key
            $table->string('Datefilling')->nullable();     //วันที่ฟ้อง
            $table->string('Branch')->nullable();          //ศาล
            $table->string('NumBlack')->nullable();        //เลขคดีดำ
            $table->string('NumRed')->nullable();          //เลขคดีแดง
            $table->string('Principal')->nullable();       //ทุนทรัพย์
            $table->string('Sue')->nullable();             //ค่าฟ้อง
            $table->string('Notefilling')->nullable();     //บันทึกเหตุขัดข้อง

            $table->string('DateExamine')->nullable();     //วันที่สืบพยาน
            $table->string('NextExamine')->nullable();     //วันที่เลือน
            $table->string('NoteExamine')->nullable();     //บันทึกเหตุขัดข้อง

            $table->string('DateCompulsory')->nullable();  //วันที่สืบพยาน
            $table->string('NextCompulsory')->nullable();  //วันที่ส่งจริง
            $table->string('DateSentence')->nullable();    //วันคัดคำพิพากษา
            $table->string('NoteCompulsory')->nullable();  //บันทึกเหตุขัดข้อง

            $table->string('DateSetofficer')->nullable();  //วันทีตั้งเจ้าพนักงาน
            $table->string('NextSetofficer')->nullable();  //วันที่ส่งจริง
            $table->string('NoteSetofficer')->nullable();  //บันทึกเหตุขัดข้อง

            $table->string('DateWarrant')->nullable();     //วันที่สืบพยาน
            $table->string('NextWarrant')->nullable();     //วันที่ส่งจริง
            $table->string('NoteWarrant')->nullable();     //บันทึกเหตุขัดข้อง
            $table->string('Warrant_Flag')->nullable();    //ได้รับ & ไมไ่ด้รับ
            $table->string('DateCall')->nullable();        //วันที่โทร
            $table->string('UpdateCall')->nullable();      //วันที่ไปรับ
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
        Schema::dropIfExists('class_courts');
    }
}
