<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustKycInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_kyc_infos', function (Blueprint $table) {
            $table->id('cust_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->string('mobile_no');
            $table->string('date_of_birth');
            $table->unsignedBigInteger('kyc_type_id');
            $table->unsignedBigInteger('ovd_type_id');
            $table->string('ovd_no');
            $table->timestamps();
            $table->foreign('kyc_type_id')->references('kyc_type_id')->on('kyc_types')->onDelete('cascade');
            $table->foreign('ovd_type_id')->references('ovd_type_id')->on('ovd_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_kyc_infos');
    }
}
