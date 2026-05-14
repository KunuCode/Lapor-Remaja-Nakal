<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $settings = SiteSetting::all()->pluck('value', 'key');

            return view('admin.settings.index', compact('settings'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat pengaturan.');
        }
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
        ], [
            'logo.required' => 'Logo wajib diupload.',
            'logo.image' => 'File harus berupa gambar.',
            'logo.mimes' => 'Format logo harus jpeg, png, jpg, gif, svg, atau ico.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
        ]);

        try {
            // Hapus logo lama jika ada
            $oldLogo = SiteSetting::where('key', 'site_logo')->first();
            if ($oldLogo && $oldLogo->value && file_exists(public_path($oldLogo->value))) {
                unlink(public_path($oldLogo->value));
            }

            $uploadPath = public_path('images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('logo');
            $filename = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $path = 'images/' . $filename;

            SiteSetting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $path]
            );

            return redirect()->back()->with('success', 'Logo berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload logo.');
        }
    }

    public function updateFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:png,ico|max:1024',
        ], [
            'favicon.required' => 'Favicon wajib diupload.',
            'favicon.image' => 'File harus berupa gambar.',
            'favicon.mimes' => 'Format favicon harus png atau ico.',
            'favicon.max' => 'Ukuran favicon maksimal 1MB.',
        ]);

        try {
            // Hapus favicon lama jika ada
            $oldFavicon = SiteSetting::where('key', 'site_favicon')->first();
            if ($oldFavicon && $oldFavicon->value && file_exists(public_path($oldFavicon->value))) {
                unlink(public_path($oldFavicon->value));
            }

            $uploadPath = public_path('images');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $request->file('favicon');
            $filename = 'favicon_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $path = 'images/' . $filename;

            SiteSetting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $path]
            );

            return redirect()->back()->with('success', 'Favicon berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload favicon.');
        }
    }

    public function updateSiteName(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
        ], [
            'site_name.required' => 'Nama website wajib diisi.',
        ]);

        try {
            SiteSetting::updateOrCreate(
                ['key' => 'site_name'],
                ['value' => $request->site_name]
            );

            SiteSetting::updateOrCreate(
                ['key' => 'site_description'],
                ['value' => $request->site_description ?? '']
            );

            return redirect()->back()->with('success', 'Pengaturan website berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengaturan.');
        }
    }
}