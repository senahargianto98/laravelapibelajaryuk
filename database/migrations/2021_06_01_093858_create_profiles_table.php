<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama');
            $table->string('sekolah');
            $table->string('jurusan');
            $table->string('user_uuid');
            $table->string('foto_profile');
            $table->string('pengalaman');
            $table->string('phone');
            $table->string('tarif');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('jadwal_start');
            $table->string('jadwal_end');
            $table->string('mengajar');
            $table->foreignId('user_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
