<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_datas', function (Blueprint $table) {
            $table->bigIncrements('Law_id');
            $table->string('Contract_no')->nullable();
            $table->string('Name')->nullable();
            $table->string('Member_no')->nullable();
            $table->string('Date_contract')->nullable();
            $table->string('Date_firstdue')->nullable();
            $table->string('Date_lastdue')->nullable();
            $table->string('Finance_request')->nullable();
            $table->string('Finance_approve')->nullable();
            $table->string('Service_charge')->nullable();
            $table->string('Total_amount')->nullable();
            $table->string('Balance_amount')->nullable();
            $table->string('Uploader')->nullable();
            $table->string('Guarantor_name')->nullable();
            $table->string('Status_notis')->nullable();
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
        Schema::dropIfExists('law_datas');
    }
}
