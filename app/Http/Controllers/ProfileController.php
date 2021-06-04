<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function store(Request $request)
    {
        $guest = new Profile;
        $guest->nama = $request->input('nama');
        $guest->sekolah = $request->input('sekolah');
        $guest->user_id = $request->input('user_id');
        $guest->timestamps = false;
        $guest->save();
        return response($guest);
    }
}
