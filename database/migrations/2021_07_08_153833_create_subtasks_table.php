<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubtasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
             $table->engine = 'InnoDB';
             $table->softDeletes();

            $table->string('name');
            $table->text('details')->nullable();
            $table->date('due_date')->nullable();

            $table->integer('task_id')->unsigned()->nullable();

            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('manager_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->date('start_date')->nullable();
            $table->date('finish_date')->nullable();

            $table->integer('contractor_id')->unsigned()->nullable();
            $table->decimal('expected_costing', 8, 2)->nullable();
            $table->decimal('actual_costing', 8, 2)->nullable();

            $table->integer('project_id')->unsigned()->nullable();
            $table->integer('activity_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtasks');
    }
}
