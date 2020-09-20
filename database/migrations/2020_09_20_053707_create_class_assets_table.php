<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_assets', function (Blueprint $table) {
            $table->bigIncrements('Assets_id');
            $table->integer('DataCus_id')->nullable();     //P-Key
            $table->string('DateAssets')->nullable();     //วันสืบทรัพย์
            $table->string('Determine')->nullable();       //วันครบกำหนดสืบ
            $table->string('Consequence')->nullable();     //ผลสืบ
            $table->string('Charges')->nullable();         //ค่าใช้จ่าย
            $table->string('NextDateAssets')->nullable(); //วันสืบใหม่
            $table->string('NoteAssets')->nullable();     //หมายเหตุ
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
        Schema::dropIfExists('class_assets');
    }
}
