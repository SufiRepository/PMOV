<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNameDetailsCostingToBillings extends Migration
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
            $table->integer('task_id')->nullable()->default(NULL);
            $table->string('name');
            $table->string('details');
            $table->integer('costing')->nullable()->default(NULL);
            $table->dateTime('billing_date');
            $table->softDeletes();
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
            $table->dropColumn('task_id');
            $table->dropColumn('name');
            $table->dropColumn('details');
            $table->dropColumn('costing');
            $table->dropColumn('billing_date');
            $table->dropColumn('deleted_at');
        });
    }
}
