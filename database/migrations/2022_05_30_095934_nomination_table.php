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
        Schema::create('nominations', function (Blueprint $table) {
            $table->id();
            $table->integer('nm_training_id')->nullable(false);
            $table->integer('nm_employee_id')->nullable(false);
            $table->integer('nm_nominated_by')->nullable(false);
            $table->integer('nm_status')->nullable(false);
            $table->string('nm_year')->nullable(false);
            $table->integer('nm_attendance')->nullable();
            $table->integer('nm_punctuality')->nullable();
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
        Schema::dropIfExists('nominations');
    }
};
