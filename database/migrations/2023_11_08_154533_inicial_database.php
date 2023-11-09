<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // create table container 
        Schema::create('container', function (Blueprint $table) {
            $table->id('container_id');
            $table->string('container_name');
            $table->integer('container_dimension');
            $table->integer('container_location');

            $table->timestamps();
        });

        // create table arduinos
        Schema::create('arduinos',function (Blueprint $table) {
            $table->id('arduino_id');
            $table->string('arduino_name');
            $table->integer('arduino_capacity');
            $table->unsignedBigInteger('container_id');

            $table->foreign('container_id')->references('container_id')->on('container');
        });

        // create table values
        Schema::create('values', function (Blueprint $table) {
            $table->id('value_id');
            // value_ph, value_temp, value_electric_conductivity all float and value_time 
            $table->float('value_ph');
            $table->float('value_temp');
            $table->float('value_electric_condutivity');
            $table->dateTime('value_time');
            $table->unsignedBigInteger('arduino_id');

            $table->foreign('arduino_id')->references('arduino_id')->on('arduinos');
        });

        // create table reles
        Schema::create('reles', function (Blueprint $table){
            $table->id('rele_id');
            $table->string('rele_name');
            $table->boolean('rele_state');
            $table->unsignedBigInteger('container_id');

            $table->foreign('container_id')->references('container_id')->on('container');
        });

        // create sensor_types
        Schema::create('sensor_types', function(Blueprint $table){
            $table->id('sensor_type_id');
            $table->string('sensor_type_name');
        });

        // create sensors 
        Schema::create('sensors', function(Blueprint $table){
            $table->id('sensor_id');
            $table->string('sensor_name');
            $table->unsignedBigInteger('sensor_type_id');
            $table->unsignedBigInteger('rele_id');

            $table->foreign('sensor_type_id')->references('sensor_type_id')->on('sensor_types');
            $table->foreign('rele_id')->references('rele_id')->on('reles');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
