<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsPublisher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NewsPublisher', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('url');
        });

        Schema::table('News', function ($table) {
            $table->integer('publisher')->unsigned()->nullable();

            $table->foreign('publisher')->references('id')->on('NewsPublisher');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NewsPublisher');
        Schema::table('News', function ($table) {
          $table->dropColumn('publisher');
        });
    }
}
