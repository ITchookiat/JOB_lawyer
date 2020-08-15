<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalssCourtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calss_courts', function (Blueprint $table) {
            $table->bigIncrements('Court_id');
            $table->integer('DataCus_id')->nullable();           //P-Key
            $table->string('Datefilling_Court')->nullable();     //วันที่ฟ้อง
            $table->string('Branch_Court')->nullable();          //ศาล
            $table->string('NumBlack_Court')->nullable();        //เลขคดีดำ
            $table->string('NumRed_Court')->nullable();          //เลขคดีแดง
            $table->string('Principal_Court')->nullable();       //ทุนทรัพย์
            $table->string('Sue_Court')->nullable();             //ชื่อผู้ใช้งาน
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
        Schema::dropIfExists('calss_courts');
    }
}
