<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $guest = Profile::select('nama','sekolah','jurusan','user_uuid','foto_profile','pengalaman','phone','tarif','time_start','time_end','jadwal_start','jadwal_end','mengajar')->get();
        return $guest;
    }

    public function store(Request $request)
    { 
        $guest = new Profile;

        $guest->nama = $request->input('nama');
        $guest->tarif = $request->input('tarif');
        $guest->sekolah = $request->input('sekolah');
        $guest->user_uuid = $request->input('user_uuid');
        $guest->phone = $request->input('phone');
        $guest->time_start = $request->input('time_start');
        $guest->time_end = $request->input('time_end');
        $guest->jadwal_start = $request->input('jadwal_start');
        $guest->jadwal_end = $request->input('jadwal_end');
        $guest->jurusan = $request->input('jurusan');
        $guest->pengalaman = $request->input('pengalaman');
        $guest->mengajar = $request->input('mengajar');
        $guest->user_id = $request->input('user_id');

        $file = $request->file('foto_profile');
        $file != "";
        $ext = $file->getClientOriginalExtension();
        $fileName = rand(10000, 50000) . '.' . $ext;
        $guest->foto_profile = '/profiles/' . $fileName;
        $file->move(base_path() . '/public/profiles', $fileName);

        $guest->timestamps = false;
        $guest->save();
        return response($guest);
    }
}
