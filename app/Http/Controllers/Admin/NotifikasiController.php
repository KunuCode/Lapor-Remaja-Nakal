<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    public function count()
    {
        $unreadCount = Report::where('is_read', false)->count();
        return response()->json(['count' => $unreadCount]);
    }

    public function latest()
    {
        $reports = Report::with('user')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'judul' => $report->title,
                    'kategori' => $report->category,
                    'lokasi' => $report->village,
                    'waktu' => $report->created_at->diffForHumans(),
                ];
            });

        return response()->json(['reports' => $reports]);
    }

    public function markAsRead($id)
    {
        $report = Report::findOrFail($id);
        $report->is_read = true;
        $report->save();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Report::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}