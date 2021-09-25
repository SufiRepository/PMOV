<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToPaymentshedulesTable extends Migration
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
            $table->integer('contractor_id')->nullable()->default(NULL);
            $table->integer('supplier_id')->nullable()->default(NULL);
            $table->integer('implementationplan_id')->nullable()->default(NULL);
            $table->integer('task_id')->nullable()->default(NULL);
            $table->integer('subtask_id')->nullable()->default(NULL);
            $table->integer('company_id')->nullable()->default(NULL);

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
            $table->dropColumn('contractor_id');
            $table->dropColumn('supplier_id');
            $table->dropColumn('implementationplan_id');
            $table->dropColumn('task_id');
            $table->dropColumn('subtask_id');
            $table->dropColumn('company_id');


        });
    }
}
