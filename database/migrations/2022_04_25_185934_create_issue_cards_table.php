<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIssueCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_card_info', function (Blueprint $table) {
            $table->id('cust_card_info_id');
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')->references('cust_id')->on('cust_kyc_infos')->onDelete('cascade');
            $table->string('card_no');
            $table->string('card_fee');
            $table->boolean('is_blocked');
            $table->string('acc_balance');
            $table->string('chip_balance')->default(0);
            $table->string('total_balance');
            $table->string('monthly_recharge');
            $table->string('eligible_limit');
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
        Schema::dropIfExists('issue_cards');
    }
}
