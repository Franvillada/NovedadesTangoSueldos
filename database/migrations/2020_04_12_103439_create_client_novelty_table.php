<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientNoveltyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_novelty', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('novelty_id');
            $table->unsignedBigInteger('client_id');
            $table->boolean('active')->default(true);

            $table->foreign('novelty_id')->references('id')->on('noveltys');
            $table->foreign('client_id')->references('id')->on('clients');
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
        Schema::dropIfExists('client_novelty');
    }
}
