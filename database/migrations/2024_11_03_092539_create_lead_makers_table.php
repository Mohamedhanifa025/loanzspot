<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lead_makers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->string('lead_maker_id');
            $table->string('lead_generation_link');
            $table->string('name');
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
        Schema::dropIfExists('lead_makers');
    }
}
