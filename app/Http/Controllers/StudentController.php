<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;


class StudentController extends Controller
{
    public function store(Request $request)
    { 
        $guest = new Student;

        $guest->username = $request->input('username');
        $guest->nama = $request->input('nama');
        $guest->jenjang_sekolah = $request->input('jenjang_sekolah');
        $guest->phone = $request->input('phone');
        $guest->email = $request->input('email');
        $guest->materi = $request->input('materi');
        $guest->time_start = $request->input('time_start');
        $guest->time_end = $request->input('time_end');
        $guest->jadwal_start = $request->input('jadwal_start');

        $guest->timestamps = false;
        $guest->save();
        return response($guest);
    }
}
