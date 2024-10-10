<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id');
            $table->string('title');
            $table->text('description');
            $table->date('start_date');
            $table->date('deadline');
            $table->enum('priority', ['high', 'middle' , 'low'])->nullable();
            $table->enum('status', ['complete', 'pending' , 'progress'])->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
