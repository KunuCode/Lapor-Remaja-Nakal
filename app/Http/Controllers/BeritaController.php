<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        try {
            $news = News::where('published', true)
                ->with('images')
                ->latest()
                ->paginate(9);

            return view('berita.index', compact('news'));
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat memuat daftar berita.');
        }
    }

    public function show($id)
    {
        try {
            $news = News::where('published', true)
                ->with('images')
                ->findOrFail($id);

            return view('berita.show', compact('news'));
        } catch (\Exception $e) {
            return redirect('/berita')->with('error', 'Berita tidak ditemukan.');
        }
    }
}
