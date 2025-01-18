<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('channel_id');
            $table->string('name');
            $table->string('admin_full_name');
            $table->string('mobile_number');
            $table->text('address');
            $table->string('city');
            $table->integer('pin_code');
            $table->date('joining_date');
            $table->tinyInteger('status')->comment('0 - Inactive, 1 - Active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
