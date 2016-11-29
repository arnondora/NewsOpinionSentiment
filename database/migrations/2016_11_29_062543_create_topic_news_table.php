<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TopicNews', function (Blueprint $table) {
            $table->integer('NewsID')->unsigned();
            $table->integer('TopicID')->unsigned();
            $table->timestamps();

            $table->foreign('NewsID')->references('id')->on('News');
            $table->foreign('TopicID')->references('id')->on('Topic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('TopicNews');
    }
}
