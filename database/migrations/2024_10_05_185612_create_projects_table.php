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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('images')->nullable();
            $table->text('files')->nullable();
            $table->date('start_date')->nullable();
            $table->date('deadline')->nullable();
            $table->enum('priority', ['high', 'middle' , 'low'])->nullable();
            $table->enum('status', ['complete', 'pending' , 'progess'])->nullable();
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
        Schema::dropIfExists('projects');
    }
};
