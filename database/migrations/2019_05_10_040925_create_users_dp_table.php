<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersDpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_users_dp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_dp')->unsigned();
            $table->string('npwp_pengurus');
            $table->string('email_pengurus');
            $table->string('foto_profile');
            $table->string('password');
            $table->timestamps();
         
            $table->foreign('id_dp')
            ->references('id')
            ->on('t_dp')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_users_dp');
    }
}
