<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('username',60)->nullable(false);
            $table->string('email',320)->nullable(false)->unique();
            $table->string('password')->nullable(false);
            $table->unsignedBigInteger('client_id')->nullable(false);
            $table->unsignedBigInteger('role_id')->nullable(false);
            $table->boolean('active')->default(true);

            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('role_id')->references('id')->on('roles');
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
