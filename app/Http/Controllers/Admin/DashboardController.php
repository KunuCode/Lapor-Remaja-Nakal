<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use App\Models\News;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalUsers = User::where('role', 'masyarakat')->count();

            $totalReports = Report::count();
            $baruReports = Report::where('status', 'baru')->count();
            $diprosesReports = Report::where('status', 'diproses')->count();
            $selesaiReports = Report::where('status', 'selesai')->count();
            $ditolakReports = Report::where('status', 'ditolak')->count();

            $totalNews = News::count();
            $publishedNews = News::where('published', true)->count();

            $recentReports = Report::with('user')->latest()->take(5)->get();

            return view('admin.dashboard', compact(
                'totalUsers',
                'totalReports',
                'baruReports',
                'diprosesReports',
                'selesaiReports',
                'ditolakReports',
                'totalNews',
                'publishedNews',
                'recentReports'
            ));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat dashboard admin.');
        }
    }
}
