<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImplementationplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('implementationplans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->softDeletes();
           
            $table->integer('user_id')->unsigned()->nullable();        
            $table->integer('company_id')->unsigned()->nullable();

            $table->string('name');
            $table->text('details')->nullable();
            $table->dateTime('contract_start_date')->nullable()->default(NULL);
            $table->dateTime('contract_end_date')->nullable()->default(NULL);
            $table->dateTime('actual_start_date')->nullable()->default(NULL);
            $table->dateTime('actual_end_date')->nullable()->default(NULL);


            
    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('implementationplans');
        
    }
}
