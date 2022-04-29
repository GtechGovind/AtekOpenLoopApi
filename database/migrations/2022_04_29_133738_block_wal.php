<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BlockWal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_wal', function (Blueprint $table) {
            $table->id('block_wal_id');
            $table->unsignedBigInteger('cust_id');
            $table->string('card_no');
            $table->foreign('cust_id')->references('cust_id')->on('cust_kyc_infos')->onDelete('cascade');
            $table->double('tnx_amount');
            $table->boolean('is_settle');
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
        //
    }
}
