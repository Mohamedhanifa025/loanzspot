<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('lead_maker_id');
            $table->decimal('amount', 8,2);
            $table->tinyInteger('status')->default(0)->comment('0 - Pending, 1 - Initiated, 2 - Transferred');
            $table->timestamps();

            $table->foreign('lead_maker_id')->references('id')->on('lead_makers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_transfers');
    }
}
