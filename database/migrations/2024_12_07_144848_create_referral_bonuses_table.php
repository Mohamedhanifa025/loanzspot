<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_bonuses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('loan_id');
            $table->unsignedInteger('referrer_id');
            $table->integer('level')->comment('1 - direct, 2 - 2nd level, 3 - 3rd level');
            $table->decimal('bonus_amount', 10, 2);
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('apply_loans')->onDelete('cascade');
            $table->foreign('referrer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_bonuses');
    }
}
