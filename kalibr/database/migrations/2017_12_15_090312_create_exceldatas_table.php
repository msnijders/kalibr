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
            // Upload ID 
            $table->integer('uploadId');
            $table->string('weld');
            $table->decimal('diameter', 10, 4);
            $table->decimal('thicknes', 10, 4);
            $table->string('surname');
            $table->string('steelgrade');
            $table->string('material');
            $table->date('weldingdate');
            $table->string('welderid');
            $table->date('documentdate');
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
