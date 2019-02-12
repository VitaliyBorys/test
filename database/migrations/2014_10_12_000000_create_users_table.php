<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['m', 'f'])->nullable();

            $table->string('password');
            $table->boolean('confirmed')->default(false);
            $table->string('confirm_token')->nullable();
            $table->string('ref_token', '20')->unique();
            $table->integer('bonuses')->default(0);
            $table->integer('money')->default(0);
            $table->dateTime('last_login')->nullable()->default(NULL);
            $table->string('card');
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
        Schema::dropIfExists('users');
    }
}
