<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $user = auth()->user();

            $totalReports = Report::where('user_id', $user->id)->count();
            $baruReports = Report::where('user_id', $user->id)->where('status', 'baru')->count();
            $diprosesReports = Report::where('user_id', $user->id)->where('status', 'diproses')->count();
            $selesaiReports = Report::where('user_id', $user->id)->where('status', 'selesai')->count();

            return view('dashboard.index', compact('totalReports', 'baruReports', 'diprosesReports', 'selesaiReports'));
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }
}
