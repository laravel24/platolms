<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration 
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('courses', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();			
            $table->mediumInteger('revision_id')->unsigned()->default(1);
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('sub_title')->nullable();
            $table->text('description')->nullable();
            $table->text('img')->nullable();
            $table->boolean('online')->nullable()->default(false);
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
		Schema::drop('courses');
	}

}
