<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttributeToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->integer('typeproject_id')->unsigned()->nullable();    
            $table->string('projectnumber')->nullable();
            $table->date('finish_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('duration')->default(0)->nullable();;
            $table->decimal('value', 8, 2)->nullable();

            



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //
            $table->dropColumn('typeproject_id');
            $table->dropColumn('projectnumber');
            $table->dropColumn('finish_date');
            $table->dropColumn('end_date');
            $table->dropColumn('duration');
            $table->dropColumn('value');

        });
    }
}
