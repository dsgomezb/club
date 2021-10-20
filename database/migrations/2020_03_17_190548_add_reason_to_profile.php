<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToProfile extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('reason')->nullable();
            $table->text('reference')->nullable();
            $table->tinyInteger('stars')->unsigned()->nullable();
            $table->string('username', 120)->unique()->after('id');
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['reason','reference', 'stars','username']);
            $table->string('firstname', 120);
            $table->string('lastname', 120);
        });
    }
}
