<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMajorsTable extends Migration 
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('majors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
            $table->integer('catalogue_id')->unsigned()->nullable();
            $table->integer('degree_id')->unsigned();
            $table->integer('college_id')->unsigned();
            $table->integer('plan_id')->unsigned()->nullable();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->integer('hours')->unsigned()->nullable();
            $table->text('description');
            $table->text('options')->nullable();
			$table->softDeletes();
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
		Schema::drop('majors');
	}

}
