<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Http\Request;

class LaporController extends Controller
{
    public function index()
    {
        return view('lapor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'required|string|max:255',
            'village' => 'required|string|max:255',
            'address' => 'required|string',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul laporan wajib diisi.',
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'category.required' => 'Kategori wajib dipilih.',
            'village.required' => 'Desa/Kelurahan wajib diisi.',
            'address.required' => 'Alamat wajib diisi.',
            'description.required' => 'Deskripsi laporan wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $report = Report::create([
                'title' => $request->title,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'category' => $request->category,
                'village' => $request->village,
                'address' => $request->address,
                'description' => $request->description,
                'status' => 'baru',
                'user_id' => auth()->id(),
            ]);

            if ($request->hasFile('images')) {
                $uploadPath = public_path('images/reports');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $order = 0;
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_report_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);
                    $path = 'images/reports/' . $filename;

                    ReportImage::create([
                        'report_id' => $report->id,
                        'image_path' => $path,
                        'caption' => null,
                        'order' => $order++,
                    ]);
                }
            }

            return redirect('/dashboard/laporan')->with('success', 'Laporan berhasil dikirim! Kami akan memproses laporan Anda.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.')->withInput();
        }
    }
}