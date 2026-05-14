<?php

namespace App\Http\Controllers;

use App\Models\SliderPhoto;
use App\Models\CamatPhoto;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        try {
            $sliders = SliderPhoto::where('active', true)
                ->orderBy('order')
                ->get();

            $camat = CamatPhoto::where('active', true)->first();

            $news = News::where('published', true)
                ->with('images')
                ->latest()
                ->take(3)
                ->get();

            return view('home', compact('sliders', 'camat', 'news'));
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat memuat halaman utama.');
        }
    }
}
