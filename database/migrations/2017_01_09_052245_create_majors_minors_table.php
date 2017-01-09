<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajorsMinorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('majors_minors', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('major_id')->unsigned()->index();
            $table->foreign('major_id')->references('id')->on('majors');
            $table->integer('minor_id')->unsigned()->index();
            $table->foreign('minor_id')->references('id')->on('minors');
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
        Schema::drop('majors_minors');
    }
}
