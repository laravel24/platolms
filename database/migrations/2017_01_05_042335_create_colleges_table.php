<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollegesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colleges', function(Blueprint $table)
        {
            $table->increments('id')->unsigned();
            $table->integer('contact_id')->unsigned();
            $table->string('name')->unique();
            $table->string('slug')->unique();
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
        Schema::drop('colleges');
    }
}
