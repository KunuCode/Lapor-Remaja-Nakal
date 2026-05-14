<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::orderBy('created_at', 'desc')->paginate(10);

            return view('admin.users.index', compact('users'));
        } catch (\Exception $e) {
            return redirect('/admin')->with('error', 'Terjadi kesalahan saat memuat data pengguna.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Tidak bisa menghapus akun admin yang sedang login
            if ($user->id === auth()->id()) {
                return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
            }

            // Tidak bisa menghapus akun admin lain
            if ($user->isAdmin()) {
                return redirect()->back()->with('error', 'Akun admin tidak dapat dihapus.');
            }

            $user->delete();

            return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengguna.');
        }
    }
}
