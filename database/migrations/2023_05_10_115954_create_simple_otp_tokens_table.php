<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleOtpTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simple_otp_tokens', function (Blueprint $table) {            
            $table->id();            
            $table->morphs('otpable');
            $table->string('procedure');
            $table->string('to');
            $table->string('token')->unique();
            $table->string('password');
            $table->timestamp('used_at')->nullable();
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('simple_otp_tokens');
    }
}
