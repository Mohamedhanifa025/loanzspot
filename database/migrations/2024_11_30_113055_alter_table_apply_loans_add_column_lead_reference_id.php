<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableApplyLoansAddColumnLeadReferenceId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apply_loans', function (Blueprint $table) {
            $table->unsignedBigInteger('lead_reference_id')->nullable()->after('customer_id');
            $table->foreign('lead_reference_id')->references('id')->on('lead_makers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apply_loans', function (Blueprint $table) {
            $table->dropForeign('apply_loans_lead_reference_id_foreign');
            $table->dropColumn('lead_reference_id');
        });
    }
}
