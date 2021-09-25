<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDurationToImplementationplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('implementationplans', function (Blueprint $table) {
            //
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
        Schema::table('implementationplans', function (Blueprint $table) {
            //
            $table->dropColumn('contract_duration');
            $table->dropColumn('actual_duration');

        });
    }
}
