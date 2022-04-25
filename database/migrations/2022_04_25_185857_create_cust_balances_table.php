<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_balances', function (Blueprint $table) {
            $table->id('cust_balance_id');
            $table->integer('cust_id');
            $table->foreign('cust_id')->references('cust_id')->on('cust_kyc_infos')->onDelete('cascade');
            $table->double('acc_balance');
            $table->double('chip_balance');
            $table->double('total_balance');
            $table->double('eligible_limit');
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
        Schema::dropIfExists('cust_balances');
    }
}
