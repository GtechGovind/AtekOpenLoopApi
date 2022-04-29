<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustTnxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_tnx', function (Blueprint $table) {
            $table->id('cus_tnx_id');
            $table->unsignedBigInteger('cust_id');
            $table->unsignedBigInteger('tnx_type_id');
            $table->foreign('cust_id')->references('cust_id')->on('cust_kyc_infos')->onDelete('cascade');
            $table->foreign('tnx_type_id')->references('tnx_type_id')->on('tnx_types')->onDelete('cascade');
            $table->double('tnx_amount');
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
        Schema::dropIfExists('cust_tnxes');
    }
}
