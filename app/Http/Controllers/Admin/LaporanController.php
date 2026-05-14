<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Report::with(['user', 'images']);

            // Filter berdasarkan status jika ada
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter berdasarkan kategori jika ada
            if ($request->filled('category')) {
                $query->where('category', $request->category);
            }

            // Pencarian
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            $reports = $query->orderBy('created_at', 'desc')->paginate(10);

            // Statistik untuk sidebar
            $statusCounts = [
                'baru' => Report::where('status', 'baru')->count(),
                'diproses' => Report::where('status', 'diproses')->count(),
                'selesai' => Report::where('status', 'selesai')->count(),
                'ditolak' => Report::where('status', 'ditolak')->count(),
            ];

            return view('admin.laporan.index', compact('reports', 'statusCounts'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data laporan.');
        }
    }

    public function show($id)
    {
        try {
            $report = Report::with(['user', 'images'])->findOrFail($id);
    $report->is_read = true;
    $report->save();
            return view('admin.laporan.show', compact('report'));
        } catch (\Exception $e) {
            return redirect('/admin/laporan')->with('error', 'Laporan tidak ditemukan.');
        }
        
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:baru,diproses,selesai,ditolak',
            'admin_note' => 'nullable|string',
        ], [
            'status.required' => 'Status wajib dipilih.',
            'status.in' => 'Status tidak valid.',
        ]);

        try {
            $report = Report::findOrFail($id);

            $report->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
            ]);

            $statusLabels = [
                'baru' => 'Baru',
                'diproses' => 'Diproses',
                'selesai' => 'Selesai',
                'ditolak' => 'Ditolak',
            ];

            $label = $statusLabels[$request->status] ?? $request->status;

            return redirect()->back()->with('success', "Status laporan berhasil diubah menjadi {$label}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status laporan.');
        }
    }
}
