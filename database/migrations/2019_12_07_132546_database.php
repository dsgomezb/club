<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Database extends Migration
{
    public function up()
    {
        //EVENTS
        Schema::create('posts', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('location');
            $table->string('zone');
            $table->string('minimum_investment');
            $table->string('company');
            $table->date('start');
            $table->mediumInteger('views')->default(0);
            $table->boolean('is_visible')->default(1);
            $table->datetime('published_at');
            $table->tinyInteger('category_id')->unsigned()->index();
            $table->mediumInteger('user_id')->unsigned()->index();
            $table->timestamps();
        });

        //CATEGORIES
        Schema::create('categories', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('value', 50);
            $table->string('slug')->unique();
            $table->timestamps();
        });

        //PLANS
        Schema::create('plans', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->float('price', 8, 2);
            $table->timestamps();
        });

        //PAYMENTS
        Schema::create('payments', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->date('date');
            $table->float('price', 8, 2);
            $table->text('payment_response')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->tinyInteger('payment_status_id')->default(1)->unsigned()->index();
            $table->mediumInteger('user_id')->unsigned()->index();
            $table->timestamps();
        });

        //PAYMENTS STATUS
        Schema::create('payment_status', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('value', 50);
            $table->timestamps();
        });

        //NEWSLETTER
        Schema::create('newsletter', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('email');
        });

        //IMAGES
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('src');
            $table->string('url')->nullable();
            $table->integer('imageable_id')->nullable()->unsigned();
            $table->string('imageable_type', 80)->nullable();
            $table->tinyInteger('is_video')->default(0)->unsigned();
            $table->boolean('pending')->default(1);
            $table->smallInteger('order')->default(0)->unsigned();
            $table->timestamps();
            //indices
            $table->index(['imageable_id', 'imageable_type']);
            $table->index('order');
        });

        //IMAGES INFO
        Schema::create('images_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('value');
            $table->integer('image_id')->unsigned()->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('plans');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('payment_status');
        Schema::dropIfExists('images');
        Schema::dropIfExists('images_info');
    }
}
