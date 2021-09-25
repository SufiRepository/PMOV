<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymenttasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paymenttasks', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('costing')->nullable()->default(NULL);
            $table->softDeletes();

            $table->integer('contractor_id')->nullable()->default(NULL);
            $table->integer('supplier_id')->nullable()->default(NULL);
            $table->integer('implementationplan_id')->nullable()->default(NULL);
            $table->integer('task_id')->nullable()->default(NULL);
            $table->integer('company_id')->nullable()->default(NULL);
            $table->integer('user_id')->nullable()->default(NULL);

            $table->string('details')->nullable();

            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paymenttasks');
    }
}
