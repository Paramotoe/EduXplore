<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Setting;
use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Autentikasi: registrasi siswa, login berlapis peran, dan logout.
 * Seluruh operasi basis data memakai Eloquent/Query Builder yang
 * di balik layar dieksekusi sebagai PDO prepared statement.
 */
class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register', [
            'registrasiBuka' => Setting::get('registrasi_buka', '1') === '1',
            'panjangNis'     => (int) Setting::get('panjang_nis', '10'),
            'namaSekolah'    => Setting::get('nama_sekolah'),
        ]);
    }

    /**
     * Proses pendaftaran siswa baru.
     * Validasi ketat ditangani oleh RegisterRequest.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // Simpan foto pada disk publik dengan nama acak (mencegah path traversal
        // maupun eksekusi berkas berbahaya melalui nama asli unggahan).
        $namaBerkas = Str::uuid()->toString() . '.' . $request->file('photo')->extension();
        $path = $request->file('photo')->storeAs('foto-profil', $namaBerkas, 'public');

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'identity'  => $data['identity'],
            'phone'     => $data['phone'],
            'kelas'     => $data['kelas'] ?? null,
            'photo'     => $path,
            'password'  => Hash::make($data['password']), // bcrypt, cost 12
            'role'      => User::ROLE_SISWA,              // registrasi mandiri selalu siswa
            'is_active' => true,
        ]);

        Audit::log('REGISTRASI', 'Pendaftaran siswa baru: ' . $user->identity, $user);

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan masuk menggunakan NIS dan kata sandi Anda.');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->homeRoute());
        }

        return view('login', ['namaSekolah' => Setting::get('nama_sekolah')]);
    }

    /**
     * Login dengan NIS/NIP atau email, dilindungi rate limiter
     * (maksimal 5 percobaan gagal per menit per kombinasi identitas + IP).
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'identity' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'identity.required' => 'NIS/NIP atau email wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $kunci = Str::lower($credentials['identity']) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($kunci, 5)) {
            $detik = RateLimiter::availableIn($kunci);
            Audit::log('LOGIN_DIBLOKIR', 'Percobaan login berlebihan: ' . $credentials['identity']);

            throw ValidationException::withMessages([
                'login_error' => "Terlalu banyak percobaan masuk. Coba lagi dalam {$detik} detik.",
            ]);
        }

        $kolom = filter_var($credentials['identity'], FILTER_VALIDATE_EMAIL) ? 'email' : 'identity';

        if (Auth::attempt([$kolom => $credentials['identity'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['login_error' => 'Akun Anda dinonaktifkan. Hubungi Admin sekolah.']);
            }

            RateLimiter::clear($kunci);
            $request->session()->regenerate(); // mitigasi session fixation

            $user->forceFill([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ])->save();

            Audit::log('LOGIN', 'Berhasil masuk sebagai ' . $user->roleLabel(), $user);

            return redirect()->intended(route($user->homeRoute()));
        }

        RateLimiter::hit($kunci, 60);
        Audit::log('LOGIN_GAGAL', 'Kredensial salah untuk: ' . $credentials['identity']);

        return back()
            ->withInput($request->only('identity'))
            ->withErrors(['login_error' => 'NIS/NIP atau kata sandi yang Anda masukkan salah.']);
    }

    public function logout(Request $request)
    {
        Audit::log('LOGOUT', 'Pengguna keluar dari sistem');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }
}
