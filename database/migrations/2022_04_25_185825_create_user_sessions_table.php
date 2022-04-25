<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sessions', function (Blueprint $table) {
            $table->id('user_session_id');
            $table->string('mobile_no');
            $table->string('otp');
            $table->dateTime('otp_created_at');
            $table->dateTime('otp_expires_at');
            $table->string('session_token')->nullable();
            $table->dateTime('session_created_at')->nullable();
            $table->dateTime('session_expires_at')->nullable();
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
        Schema::dropIfExists('user_sessions');
    }
}
