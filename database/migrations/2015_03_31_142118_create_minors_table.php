<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMinorsTable extends Migration 
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('minors', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
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
		Schema::drop('minors');
	}

}
