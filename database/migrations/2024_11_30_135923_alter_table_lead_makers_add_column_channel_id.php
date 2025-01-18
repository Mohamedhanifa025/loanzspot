<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableLeadMakersAddColumnChannelId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lead_makers', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id')->nullable()->after('id');
            $table->foreign('channel_id')->references('id')->on('channels')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lead_makers', function (Blueprint $table) {
            $table->dropForeign('lead_makers_channel_id_foreign');
            $table->dropColumn('channel_id');
        });
    }
}
