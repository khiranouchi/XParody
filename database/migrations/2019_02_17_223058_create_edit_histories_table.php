<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('song_id');
            $table->unsignedInteger('user_id')->nullable();
            $table->tinyInteger('edit_type');
            $table->timestamps();
            $table->index('song_id');
            $table->foreign('song_id')->references('id')->on('songs')->onDelete('cascade');
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
        Schema::dropIfExists('edit_histories');
    }
}
