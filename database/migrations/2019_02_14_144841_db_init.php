<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DbInit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();
        });

        Schema::create('rappels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamp('date_day')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('todos');
    }
}
