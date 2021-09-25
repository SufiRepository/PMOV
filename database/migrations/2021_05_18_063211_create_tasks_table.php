<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('project_id')->nullable();
            $table->string('name');
            $table->text('details')->nullable();
            $table->date('due_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->date('finish_date')->nullable();  
            $table->integer('contractor_id')->unsigned()->nullable();
            $table->decimal('expected_costing', 8, 2)->nullable();
            $table->decimal('actual_costing', 8, 2)->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->integer('manager_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('milestone_id')->unsigned()->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->date('start_date')->nullable(); 
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
        Schema::dropIfExists('tasks');
    }
}
