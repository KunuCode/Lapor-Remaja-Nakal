<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        try {
            $profiles = Profile::all()->keyBy('type');

            $visiMisi = $profiles->get('visi_misi');
            $struktur = $profiles->get('struktur');
            $about = $profiles->get('about');

            return view('profil', compact('visiMisi', 'struktur', 'about'));
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat memuat halaman profil.');
        }
    }
}
