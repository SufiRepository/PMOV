<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdProjectIdSoftdelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('teams', function (Blueprint $table) {
            //
            $table->integer('user_id')->nullable()->default(NULL); 
            $table->integer('project_id')->nullable()->default(NULL); 
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
        //
        Schema::table('teams', function ($table) {
			$table->dropColumn('user_id');
            $table->dropColumn('project_id');
            $table->dropColumn('deleted_at');
		});
    }
}
