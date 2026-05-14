<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        try {
            $reports = Report::where('user_id', auth()->id())
                ->with('images')
                ->latest()
                ->paginate(10);

            return view('dashboard.laporan.index', compact('reports'));
        } catch (\Exception $e) {
            return redirect('/dashboard')->with('error', 'Terjadi kesalahan saat memuat daftar laporan.');
        }
    }

    public function show($id)
    {
        try {
            $report = Report::where('user_id', auth()->id())
                ->with('images')
                ->findOrFail($id);

            return view('dashboard.laporan.show', compact('report'));
        } catch (\Exception $e) {
            return redirect('/dashboard/laporan')->with('error', 'Laporan tidak ditemukan.');
        }
    }
}
