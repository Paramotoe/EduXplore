<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Support\Audit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Manajemen akun pengguna untuk Admin Sekolah & Super Admin.
 */
class UserController extends Controller
{
    /** Daftar pengguna dengan pencarian & penyaringan peran. */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));
        $role    = (string) $request->query('role', '');

        $query = User::query()->latest();

        // Parameter di-binding otomatis sebagai prepared statement.
        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('identity', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if (array_key_exists($role, User::ROLES)) {
            $query->where('role', $role);
        }

        // Admin sekolah tidak boleh melihat maupun menyentuh akun Super Admin.
        if (! Auth::user()->isSuperAdmin()) {
            $query->where('role', '!=', User::ROLE_SUPER_ADMIN);
        }

        return view('admin.users.index', [
            'users'   => $query->paginate(10)->withQueryString(),
            'keyword' => $keyword,
            'role'    => $role,
        ]);
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User(['role' => User::ROLE_SISWA])]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();
        $data['password']  = Hash::make($data['password']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['photo']     = $this->simpanFoto($request);

        $user = User::create($data);
        Audit::log('BUAT_AKUN', "Membuat akun {$user->identity} ({$user->roleLabel()})");

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun pengguna berhasil dibuat.');
    }

    public function edit(string $id)
    {
        return view('admin.users.form', ['user' => $this->cari($id)]);
    }

    public function update(UserRequest $request, string $id)
    {
        $user = $this->cari($id);
        $data = $request->validated();

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_active'] = $request->boolean('is_active', false);

        if ($foto = $this->simpanFoto($request)) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $data['photo'] = $foto;
        }

        // Pengaman: pengguna tidak dapat menurunkan perannya sendiri
        // atau menonaktifkan akunnya sendiri.
        if ($user->id === Auth::id()) {
            $data['role']      = $user->role;
            $data['is_active'] = true;
        }

        $user->update($data);
        Audit::log('UBAH_AKUN', "Memperbarui akun {$user->identity}");

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = $this->cari($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['aksi' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        if ($user->photo) {
            Storage::disk('public')->delete($user->photo);
        }

        $identitas = $user->identity;
        $user->delete();
        Audit::log('HAPUS_AKUN', "Menghapus akun {$identitas}");

        return back()->with('success', 'Akun pengguna berhasil dihapus.');
    }

    /** Aktif/nonaktifkan akun tanpa menghapus data akademik. */
    public function toggle(string $id)
    {
        $user = $this->cari($id);

        if ($user->id === Auth::id()) {
            return back()->withErrors(['aksi' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.']);
        }

        $user->update(['is_active' => ! $user->is_active]);
        Audit::log('UBAH_STATUS_AKUN', "Status akun {$user->identity}: " . ($user->is_active ? 'aktif' : 'nonaktif'));

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }

    /** Mengambil pengguna sambil menegakkan batas kewenangan Admin. */
    private function cari(string $id): User
    {
        $user = User::findOrFail($id);

        if ($user->isSuperAdmin() && ! Auth::user()->isSuperAdmin()) {
            abort(403, 'Akun Super Admin hanya dapat dikelola oleh Super Admin.');
        }

        return $user;
    }

    private function simpanFoto(Request $request): ?string
    {
        if (! $request->hasFile('photo')) {
            return null;
        }

        $nama = Str::uuid()->toString() . '.' . $request->file('photo')->extension();

        return $request->file('photo')->storeAs('foto-profil', $nama, 'public');
    }
}
