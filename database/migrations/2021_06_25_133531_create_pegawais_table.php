<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip', 100)->unique();
            $table->string('nama', 100);
            $table->string('email', 100)->unique();
            $table->string('nohp', 20);
            $table->string('alamat', 150);
            $table->bigInteger('departemen_id')->unsigned();
            $table->timestamps();

            $table->foreign('departemen_id')->references('id')->on('departemens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegawais');
    }
}
