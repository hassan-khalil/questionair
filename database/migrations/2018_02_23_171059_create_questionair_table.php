<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionairTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionair', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('time');
            $table->enum('duration',['Minutes','Hours'])->default('Minutes');
            $table->enum('canResume',['Yes','No'])->default('Yes');
            $table->enum('published',['Yes','No'])->default('No');
            $table->timestamps();
        });

         Schema::table('questionair', function(Blueprint $table){
             $table->foreign('user_id')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questionair');
    }
}
