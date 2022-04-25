<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigurationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuration_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('otp_validity');
            $table->unsignedBigInteger('otp_validity_unit');
            $table->foreign('otp_validity_unit')->references('unit_type_id')->on('unit_types')->onDelete('cascade');
            $table->integer('otp_digit_count');
            $table->integer('session_validity');
            $table->unsignedBigInteger('session_validity_unit');
            $table->foreign('session_validity_unit')->references('unit_type_id')->on('unit_types')->onDelete('cascade');
            $table->integer('min_kyc_account_balance_limit');
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
        Schema::dropIfExists('configuration_settings');
    }
}
