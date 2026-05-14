<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

            return view('admin.profil.index', compact('visiMisi', 'struktur', 'about'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data profil.');
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:visi_misi,struktur,about',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'type.required' => 'Tipe profil wajib dipilih.',
            'title.required' => 'Judul wajib diisi.',
            'content.required' => 'Konten wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $profile = Profile::where('type', $request->type)->first();

            $data = [
                'type' => $request->type,
                'title' => $request->title,
                'content' => $request->content,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($profile && $profile->image_path && file_exists(public_path($profile->image_path))) {
                    unlink(public_path($profile->image_path));
                }

                $uploadPath = public_path('images/profiles');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file = $request->file('image');
                $filename = time() . '_profile_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['image_path'] = 'images/profiles/' . $filename;
            }

            if ($profile) {
                $profile->update($data);
            } else {
                Profile::create($data);
            }

            $typeLabels = [
                'visi_misi' => 'Visi & Misi',
                'struktur' => 'Struktur Organisasi',
                'about' => 'Tentang Kecamatan',
            ];

            $label = $typeLabels[$request->type] ?? $request->type;

            return redirect()->back()->with('success', "Profil {$label} berhasil diperbarui.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.');
        }
    }
}