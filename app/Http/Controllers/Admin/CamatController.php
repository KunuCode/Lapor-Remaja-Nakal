<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CamatPhoto;
use Illuminate\Http\Request;

class CamatController extends Controller
{
    public function index()
    {
        try {
            $camats = CamatPhoto::orderBy('created_at', 'desc')->get();

            return view('admin.camat.index', compact('camats'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data camat.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ], [
            'image.required' => 'Foto camat wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
            'name.required' => 'Nama camat wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
        ]);

        try {
            $uploadPath = public_path('images/camat');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image');
            $filename = time() . '_camat_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $path = 'images/camat/' . $filename;

            CamatPhoto::create([
                'image_path' => $path,
                'name' => $request->name,
                'position' => $request->position,
                'bio' => $request->bio,
                'active' => true,
            ]);

            return redirect()->back()->with('success', 'Data camat berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan data camat.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Nama camat wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $camat = CamatPhoto::findOrFail($id);

            $data = [
                'name' => $request->name,
                'position' => $request->position,
                'bio' => $request->bio,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($camat->image_path && file_exists(public_path($camat->image_path))) {
                    unlink(public_path($camat->image_path));
                }

                $uploadPath = public_path('images/camat');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file = $request->file('image');
                $filename = time() . '_camat_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['image_path'] = 'images/camat/' . $filename;
            }

            $camat->update($data);

            return redirect()->back()->with('success', 'Data camat berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data camat.');
        }
    }

    public function destroy($id)
    {
        try {
            $camat = CamatPhoto::findOrFail($id);

            // Hapus file gambar
            if ($camat->image_path && file_exists(public_path($camat->image_path))) {
                unlink(public_path($camat->image_path));
            }

            $camat->delete();

            return redirect()->back()->with('success', 'Data camat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data camat.');
        }
    }
}