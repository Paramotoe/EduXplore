<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

/**
 * Pengelolaan profil pribadi dan daftar siswa binaan guru.
 */
class ProfileController extends Controller
{
    public function index()
    {
        return view('profil', ['user' => User::findOrFail(Auth::id())]);
    }

    public function updateSelf(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $data = $request->validate([
            'name'  => ['required', 'string', 'regex:/^[A-Za-z\s\.\']+$/u', 'max:100'],
            'email' => ['required', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'photo' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.regex'  => 'Nama hanya boleh berisi huruf dan spasi.',
            'phone.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'phone.min'   => 'Nomor telepon minimal 10 digit.',
            'photo.mimes' => 'Format foto hanya boleh JPG, JPEG, atau PNG.',
            'photo.max'   => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $nama = Str::uuid()->toString() . '.' . $request->file('photo')->extension();
            $data['photo'] = $request->file('photo')->storeAs('foto-profil', $nama, 'public');
        }

        $user->update($data);
        Audit::log('UBAH_PROFIL', 'Memperbarui data profil pribadi');

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
        ], [
            'password.min'       => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        if (! Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini salah.']);
        }

        $user->update(['password' => Hash::make($request->input('password'))]);
        Audit::log('UBAH_SANDI', 'Mengganti kata sandi akun');

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }

    public function deleteSelf(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($user->isSuperAdmin()) {
            return back()->withErrors(['aksi' => 'Akun Super Admin tidak dapat dihapus demi keamanan sistem.']);
        }

        Audit::log('HAPUS_AKUN_SENDIRI', 'Menghapus akun pribadi: ' . $user->identity, $user);

        Auth::logout();
        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Akun Anda telah dihapus secara permanen.');
    }

    /** Daftar siswa untuk guru (hanya baca). */
    public function kelolaSiswa()
    {
        return view('guru.kelola_siswa', [
            'siswa' => User::where('role', User::ROLE_SISWA)->orderBy('name')->get(),
        ]);
    }
}
