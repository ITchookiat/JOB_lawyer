<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataUploadFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_upload_files', function (Blueprint $table) {
            $table->bigIncrements('File_id');
            $table->integer('DataCus_id')->nullable();   //P-Key
            $table->string('Type_file')->nullable();     //ประเภท
            $table->string('Name_file')->nullable();     //ชื่อ
            $table->string('Size_file')->nullable();     
            $table->string('Date_file')->nullable();     
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
        Schema::dropIfExists('data_upload_files');
    }
}
