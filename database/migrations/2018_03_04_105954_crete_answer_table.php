<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreteAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questions_id')->unsigned();
            $table->text('answer');
            $table->enum('correct',[0,1])->default(0);
            $table->timestamps();
        });

         Schema::table('answers', function(Blueprint $table){
             $table->foreign('questions_id')->references('id')->on('questions')->onDelete('CASCADE')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
}
