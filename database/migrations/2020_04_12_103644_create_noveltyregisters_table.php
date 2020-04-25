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
        Schema::create('noveltyregisters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable(false);
            $table->double('quantity',4,2)->nullable(false);
            $table->date('date')->nullable(false);
            $table->unsignedBigInteger('novelty_id')->nullable(false);
            $table->boolean('informed')->default(false);

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('novelty_id')->references('id')->on('noveltys');
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
        Schema::dropIfExists('noveltyregisters');
    }
}
