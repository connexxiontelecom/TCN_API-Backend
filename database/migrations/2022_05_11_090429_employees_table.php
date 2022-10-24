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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable(false);
            $table->string('email')->nullable(false);
            $table->string('phone')->nullable()->unique();
            $table->string('dob')->nullable();
            $table->integer('department')->nullable();
            $table->string('staff_id')->nullable(false)->unique();
            $table->string('designation')->nullable(false);
            $table->string('date_of_appointment')->nullable();
            $table->string('type')->nullable();
            $table->string('job_trade')->nullable();
            $table->string('location')->nullable();
            $table->integer('status')->nullable(false);
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
        Schema::dropIfExists('employees');
    }
};
