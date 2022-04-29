<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_inv', function (Blueprint $table) {
            $table->id('card_inv_id');
            $table->string('card_no');
            $table->integer('card_fee');
            $table->string('card_pan_no');
            $table->string('card_cvv_no');
            $table->string('card_expiry');
            $table->boolean('is_issued');
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
        Schema::dropIfExists('card_inventories');
    }
}
