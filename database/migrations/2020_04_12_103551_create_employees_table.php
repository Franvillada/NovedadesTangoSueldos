<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable(false);
            $table->string('name',60);
            $table->integer('employee_number')->nullable(false);
            $table->boolean('active')->default(true);
            $table->date('entry_date')->nullable(false);
            $table->date('leave_date')->nullable(true);
            $table->integer('vacations');
            $table->integer('scoring');

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
        Schema::dropIfExists('employees');
    }
}
