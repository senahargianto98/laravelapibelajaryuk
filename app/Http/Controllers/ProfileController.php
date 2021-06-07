<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Ramsey\Uuid\Uuid;

class ProfileController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Profile::select('mengajar','foto_profile','pengalaman','jurusan','jadwal_start','jadwal_end','nama','sekolah','user_uuid')->get();
        return ($user);
    } 

    public function store(Request $request)
    { 
        $guest = new Profile;

        $guest->nama = $request->input('nama');
        $guest->sekolah = $request->input('sekolah');

        $guest->user_uuid = Uuid::uuid4()->getHex();
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
