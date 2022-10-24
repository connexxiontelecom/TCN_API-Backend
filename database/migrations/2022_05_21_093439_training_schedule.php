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
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('ts_title')->nullable(false);
            $table->longText('ts_description')->nullable(false);
            $table->string('ts_type')->nullable(false);
            $table->integer('ts_department')->nullable(false);
            $table->string('ts_start')->nullable(false);
            $table->string('ts_end')->nullable(false);
            $table->string('ts_cost')->nullable(false);
            $table->string('ts_facilitator')->nullable();
            $table->integer('ts_approved_by')->nullable();
            $table->string('ts_approved_on')->nullable();
            $table->integer('ts_year')->nullable(false);
            $table->integer('ts_status')->nullable(false);
            $table->integer('ts_created_by')->nullable(false);
            $table->longText('ts_evaluation_note')->nullable();
            $table->integer('ts_instructor_rating')->nullable();
            $table->integer('ts_training_rating')->nullable();
            $table->rememberToken();
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
        //
        Schema::dropIfExists('years');
    }
};
