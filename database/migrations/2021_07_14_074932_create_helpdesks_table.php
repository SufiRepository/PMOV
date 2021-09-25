<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHelpdesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helpdesks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->softDeletes();

            $table->integer('user_id')->unsigned()->nullable();        
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();

            $table->string('name');
            $table->string('notes');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('helpdesks');
    }
}
