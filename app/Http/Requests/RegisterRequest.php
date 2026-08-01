<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi ketat formulir pendaftaran siswa baru.
 */
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Setting::get('registrasi_buka', '1') === '1';
    }

    public function rules(): array
    {
        $panjangNis = (int) Setting::get('panjang_nis', '10');

        return [
            'identity' => [
                'required', 'string', 'regex:/^[0-9]+$/',
                'digits:' . $panjangNis,
                Rule::unique('users', 'identity'),
            ],
            'name' => ['required', 'string', 'regex:/^[A-Za-z\s\.\']+$/u', 'min:3', 'max:100'],
            'email' => [
                'required', 'string', 'email:rfc', 'max:255',
                Rule::unique('users', 'email'),
            ],
            'phone'    => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'password' => ['required', 'string', 'min:8', 'max:72', 'confirmed'],
            'kelas'    => ['nullable', 'string', 'max:20'],
            'photo'    => ['required', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'identity' => 'NIS/NIM',
            'name'     => 'Nama Lengkap',
            'email'    => 'Email',
            'phone'    => 'Nomor Telepon',
            'password' => 'Kata Sandi',
            'photo'    => 'Foto Profil',
        ];
    }

    public function messages(): array
    {
        $panjangNis = (int) Setting::get('panjang_nis', '10');

        return [
            'identity.required' => 'NIS/NIM wajib diisi.',
            'identity.regex'    => 'NIS/NIM hanya boleh berisi angka.',
            'identity.digits'   => "NIS/NIM harus terdiri atas tepat {$panjangNis} digit angka sesuai ketentuan sekolah.",
            'identity.unique'   => 'NIS/NIM tersebut sudah terdaftar pada sistem.',
            'name.required'     => 'Nama lengkap wajib diisi.',
            'name.regex'        => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
            'name.min'          => 'Nama lengkap minimal 3 karakter.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid, contoh: nama@sekolah.sch.id',
            'email.unique'      => 'Email tersebut sudah digunakan oleh pengguna lain.',
            'phone.required'    => 'Nomor telepon wajib diisi.',
            'phone.regex'       => 'Nomor telepon hanya boleh berisi angka.',
            'phone.min'         => 'Nomor telepon minimal 10 digit.',
            'phone.max'         => 'Nomor telepon maksimal 15 digit.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 8 karakter.',
            'password.confirmed'=> 'Konfirmasi kata sandi tidak cocok.',
            'photo.required'    => 'Foto profil wajib diunggah.',
            'photo.image'       => 'Berkas yang diunggah harus berupa gambar.',
            'photo.mimes'       => 'Format foto hanya boleh JPG, JPEG, atau PNG.',
            'photo.max'         => 'Ukuran foto maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'identity' => trim((string) $this->input('identity')),
            'name'     => preg_replace('/\s+/', ' ', trim((string) $this->input('name'))),
            'email'    => strtolower(trim((string) $this->input('email'))),
            'phone'    => preg_replace('/[\s\-\+]/', '', (string) $this->input('phone')),
        ]);
    }
}
