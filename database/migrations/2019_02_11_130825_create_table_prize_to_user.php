<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePrizeToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prize_to_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('prize_id')->nullable()->default(NULL);
            $table->enum('prize_type', ['physical', 'bonus', 'money']);
            $table->string('value')->nullable()->default()->null();
            $table->string('status');
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
        Schema::dropIfExists('prize_to_user');
    }
}
