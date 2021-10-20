<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrateCalificationsTable extends Migration
{
    public function up()
    {
        Schema::create('califications', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('stars')->unsigned();
            $table->mediumInteger('post_id'); //posteo del cual se califica
            $table->mediumInteger('author_id'); //usuario que califica
            // $table->mediumInteger('user_id'); //usuario que recibe la calificación
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('califications');
    }
}
