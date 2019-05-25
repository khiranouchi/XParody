<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->tinyInteger('access_level')->nullable();
            $table->unsignedInteger('creator_user_id')->nullable();
            $table->foreign('creator_user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('access_level');
            $table->dropColumn('creator_user_id');
        });
    }
}
