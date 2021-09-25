<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAttributeToSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            //
            $table->dateTime('contract_start_date')->nullable()->default(NULL);
            $table->dateTime('contract_end_date')->nullable()->default(NULL);
            $table->dateTime('actual_start_date')->nullable()->default(NULL);
            $table->dateTime('actual_end_date')->nullable()->default(NULL);
            $table->integer('contract_duration')->nullable()->default(NULL);
            $table->integer('actual_duration')->nullable()->default(NULL);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtasks', function (Blueprint $table) {
            //
            $table->dropColumn('contract_start_date');
            $table->dropColumn('contract_end_date');
            $table->dropColumn('actual_start_date');
            $table->dropColumn('actual_end_date');
            $table->dropColumn('contract_duration');
            $table->dropColumn('actual_duration');
            
        });
    }
}
