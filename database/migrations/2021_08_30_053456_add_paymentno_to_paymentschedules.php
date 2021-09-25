<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentnoToPaymentschedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymentschedules', function (Blueprint $table) {
            //
            $table->string('payment_no')->nullable()->default(NULL);
            $table->string('file_payment_no')->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentschedules', function (Blueprint $table) {
            //
        });
    }
}
