<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoveltyregistersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('novelty_registers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->double('quantity',4,2);
            $table->date('date');
            $table->unsignedBigInteger('novelty_id');
            $table->boolean('informed')->default(false);

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('novelty_id')->references('id')->on('novelties');
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
        Schema::dropIfExists('novelty_registers');
    }
}
