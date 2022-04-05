<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInscriptionsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscriptions_details', function (Blueprint $table) {
            $table->bigInteger('idInscription')->unsigned();
            $table->bigInteger('idSubject')->unsigned();
            $table->timestamps();
            $table->foreign('idInscription')->references('id')->on('inscriptions');
            $table->foreign('idSubject')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inscriptions_details');
    }
}
