<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupportingdocumentsToBillings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('billings', function (Blueprint $table) {
            //
            $table->string('invoice_no')->nullable()->default(NULL);
            $table->string('deliveryorder_no')->nullable()->default(NULL);
            $table->string('supportingdocument')->nullable()->default(NULL);

            $table->string('file_invoice')->nullable()->default(NULL);
            $table->string('file_deliveryorder')->nullable()->default(NULL);
            $table->string('file_supportingdocument')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('billings', function (Blueprint $table) {
            //
        });
    }
}
