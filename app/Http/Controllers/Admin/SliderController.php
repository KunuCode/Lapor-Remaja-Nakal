<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SliderPhoto;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $sliders = SliderPhoto::orderBy('order')->get();

            return view('admin.slider.index', compact('sliders'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data slider.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
        ], [
            'image.required' => 'Gambar slider wajib diupload.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $uploadPath = public_path('images/sliders');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('image');
            $filename = time() . '_slider_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $path = 'images/sliders/' . $filename;

            SliderPhoto::create([
                'image_path' => $path,
                'caption' => $request->caption,
                'order' => $request->order ?? 0,
                'active' => true,
            ]);

            return redirect()->back()->with('success', 'Slider berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan slider.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $slider = SliderPhoto::findOrFail($id);

            $data = [
                'caption' => $request->caption,
                'order' => $request->order ?? 0,
            ];

            if ($request->hasFile('image')) {
                // Hapus gambar lama
                if ($slider->image_path && file_exists(public_path($slider->image_path))) {
                    unlink(public_path($slider->image_path));
                }

                $uploadPath = public_path('images/sliders');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $file = $request->file('image');
                $filename = time() . '_slider_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $data['image_path'] = 'images/sliders/' . $filename;
            }

            $slider->update($data);

            return redirect()->back()->with('success', 'Slider berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui slider.');
        }
    }

    public function destroy($id)
    {
        try {
            $slider = SliderPhoto::findOrFail($id);

            // Hapus file gambar
            if ($slider->image_path && file_exists(public_path($slider->image_path))) {
                unlink(public_path($slider->image_path));
            }

            $slider->delete();

            return redirect()->back()->with('success', 'Slider berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus slider.');
        }
    }

    public function toggleActive($id)
    {
        try {
            $slider = SliderPhoto::findOrFail($id);
            $slider->update(['active' => !$slider->active]);

            $status = $slider->active ? 'diaktifkan' : 'dinonaktifkan';

            return redirect()->back()->with('success', "Slider berhasil {$status}.");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah status slider.');
        }
    }
}