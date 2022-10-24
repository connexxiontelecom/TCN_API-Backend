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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->string('rec_name')->nullable(false);
            $table->longText('rec_description')->nullable(false);
            $table->string('rec_type')->nullable(false);
            $table->integer('rec_employee')->nullable(false);
            $table->integer('rec_recommended_by')->nullable(false);
            /*$table->string('rec_designation')->nullable(false);
            $table->string('rec_region')->nullable(false);*/
            $table->string('rec_year')->nullable(false);
            $table->integer('rec_status')->nullable();
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
        Schema::dropIfExists('recommendations');
    }
};
