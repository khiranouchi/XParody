<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLyricsBoxLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lyrics_box_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('box_id');
            $table->unsignedInteger('line_idx');
            $table->text('lyrics_new');
            $table->tinyInteger('level');
            $table->unsignedInteger('user_id')->nullable();
            $table->index('box_id');
            $table->foreign('box_id')->references('id')->on('lyrics_boxes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lyrics_box_lines');
    }
}
