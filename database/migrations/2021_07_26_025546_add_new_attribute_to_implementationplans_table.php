<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewAttributeToImplementationplansTable extends Migration
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

            $table->integer('project_id')->nullable()->default(NULL);
            $table->integer('status_id')->nullable()->default(NULL);
      
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
            $table->dropColumn('project_id');
            $table->dropColumn('status_id');
        });
    }
}
