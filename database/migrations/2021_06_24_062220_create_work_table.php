<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('user_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('location_id')->nullable();

            $table->string('name');
            $table->text('details')->nullable();
            $table->decimal('costing', 8, 2)->nullable();
            $table->date('due_date')->nullable();
            $table->date('start_date')->nullable();

            $table->softDeletes();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('contactor_id')->unsigned()->nullable();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work');
    }
}
