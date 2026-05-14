<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        try {
            $news = News::with('images')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('admin.berita.index', compact('news'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data berita.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'published' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $news = News::create([
                'title' => $request->title,
                'content' => $request->content,
                'summary' => $request->summary,
                'link' => $request->link,
                'published' => $request->has('published'),
            ]);

            if ($request->hasFile('images')) {
                $uploadPath = public_path('images/news');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $order = 0;
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_news_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);
                    $path = 'images/news/' . $filename;

                    NewsImage::create([
                        'news_id' => $news->id,
                        'image_path' => $path,
                        'caption' => null,
                        'order' => $order++,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan berita.')->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string',
            'link' => 'nullable|string|max:255',
            'published' => 'nullable|boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul berita wajib diisi.',
            'content.required' => 'Konten berita wajib diisi.',
            'images.*.image' => 'File harus berupa gambar.',
            'images.*.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif.',
            'images.*.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        try {
            $news = News::findOrFail($id);

            $news->update([
                'title' => $request->title,
                'content' => $request->content,
                'summary' => $request->summary,
                'link' => $request->link,
                'published' => $request->has('published'),
            ]);

            if ($request->hasFile('images')) {
                $uploadPath = public_path('images/news');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                $order = $news->images()->max('order') ?? -1;
                $order++;

                foreach ($request->file('images') as $image) {
                    $filename = time() . '_news_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);
                    $path = 'images/news/' . $filename;

                    NewsImage::create([
                        'news_id' => $news->id,
                        'image_path' => $path,
                        'caption' => null,
                        'order' => $order++,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui berita.');
        }
    }

    public function destroy($id)
    {
        try {
            $news = News::findOrFail($id);

            // Hapus semua gambar terkait
            foreach ($news->images as $image) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
            }

            $news->delete();

            return redirect()->back()->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus berita.');
        }
    }

    public function deleteImage($id)
    {
        try {
            $image = NewsImage::findOrFail($id);

            if (file_exists(public_path($image->image_path))) {
                unlink(public_path($image->image_path));
            }

            $image->delete();

            return redirect()->back()->with('success', 'Gambar berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus gambar.');
        }
    }
}