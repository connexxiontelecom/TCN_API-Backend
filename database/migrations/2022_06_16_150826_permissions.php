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
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p_user_id');
            $table->integer('p_recommend');
            $table->integer('p_manage_employees');
            $table->integer('p_schedule');
            $table->integer('p_create_training');
            $table->integer('p_nominate');
            $table->integer('p_setup');
            $table->integer('p_archive');
            $table->integer('p_report');
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
        Schema::dropIfExists('permissions');
    }
};
