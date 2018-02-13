<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExceldatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exceldatas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uploadId');
            $table->string('weld');
            $table->string('diameter');
            $table->string('thicknes');
            $table->string('surname');
            $table->string('steelgrade');
            $table->string('material');
            $table->string('weldingdate');
            $table->string('welderid');
            $table->string('requestid');
            $table->string('documentdate');
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
        Schema::dropIfExists('exceldatas');
    }
}
