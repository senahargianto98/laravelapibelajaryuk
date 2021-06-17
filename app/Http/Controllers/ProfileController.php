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

    public function edit($id)
    {
        $guest = Profile::where('user_uuid', $id)->first();
        return $guest;
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $guest = Profile::find($id);
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

        $guest->timestamps = false;

        if ($request->file('foto_profile') == "") {
            $guest->foto_profile = $guest->foto_profile;
        }else {
            $file = $request->file('foto_profile');
            $file != "";
            $ext = $file->getClientOriginalExtension();
            $fileName = rand(10000, 50000) . '.' . $ext;
            $guest->foto_profile = '/profiles/' . $fileName;
            $file->move(base_path() . '/public/profiles', $fileName);
        }        
        $guest->save();
        return response($guest);
    }

    public function store(Request $request)
    { 
        $rules = [
            'nama' => 'required|unique:profiles,nama',
            'tarif' => 'required',
            'sekolah' => 'required',
            'phone' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'jadwal_start' => 'required',
            'jadwal_end' => 'required',
            'jurusan' => 'required',
            'pengalaman' => 'required',
            'mengajar' => 'required',
            'foto_profile' => 'required',
        ];
        
        $messages = [
            'nama.required' => 'Isi Nama Anda',
            'tarif.required' => 'Isi Tarif Anda',
            'sekolah.required' => 'Isi Sekolah Anda',
            'time_start.required' => 'Isi Jam Mulai Mengajar Anda',
            'time_end.required' => 'Isi Jam Selesai Mengajar Anda',
            'jadwal_start.required' => 'Isi Jadwal Mulai Mengajar Anda',
            'jadwal_end.required' => 'Isi Jadwal Akhir Mengajar Anda',
            'pengalaman.required' => 'Isi Pengelaman Anda',
            'mengajar.required' => 'Isi Anda Mengajar Apa',
            'foto_profile.required' => 'Upload Foto Profile Anda',
            'unique' => 'Nama sudah di gunakan',
        ];
        
        $request->validate($rules,$messages);
        
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
