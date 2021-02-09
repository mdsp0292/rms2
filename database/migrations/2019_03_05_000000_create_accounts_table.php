<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('country', 2)->nullable();
            $table->string('post_code', 25)->nullable();
            $table->integer('user_id')->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
