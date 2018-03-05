<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questionair_id')->unsigned();
            $table->enum('question_type',['multiple choice','text']);
            $table->timestamps();
        });

         Schema::table('type', function(Blueprint $table){
             $table->foreign('questionair_id')->references('id')->on('questionair')->onDelete('CASCADE')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type');
    }
}
