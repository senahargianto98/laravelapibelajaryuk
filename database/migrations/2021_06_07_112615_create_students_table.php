<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('nama');
            $table->string('jenjang_sekolah');
            $table->string('phone');
            $table->string('email');
            $table->string('materi');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('jadwal_start');
            $table->foreignId('user_id')->default('1')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
