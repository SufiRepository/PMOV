<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('user_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->string('address',50)->nullable()->default(NULL);
            $table->string('address2',50)->nullable()->default(NULL);
            $table->string('city')->nullable()->default(NULL);
            $table->string('state',2)->nullable()->default(NULL);
            $table->string('country',2)->nullable()->default(NULL);
            $table->string('phone',20)->nullable()->default(NULL);
            $table->string('fax',20)->nullable()->default(NULL);
            $table->string('email',150)->nullable()->default(NULL);
            $table->string('contact',100)->nullable()->default(NULL);
            $table->string('notes')->nullable()->default(NULL);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('contractors');
    }
}
