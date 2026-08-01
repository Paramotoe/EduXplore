<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

/**
 * Validasi pembuatan & pembaruan akun oleh Admin / Super Admin.
 */
class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->isStaff();
    }

    public function rules(): array
    {
        $id = $this->route('id');
        $rolesDiizinkan = Auth::user()->isSuperAdmin()
            ? array_keys(User::ROLES)
            : [User::ROLE_GURU, User::ROLE_SISWA, User::ROLE_ADMIN];

        return [
            'identity' => ['required', 'string', 'regex:/^[0-9]+$/', 'min:5', 'max:20',
                            Rule::unique('users', 'identity')->ignore($id)],
            'name'     => ['required', 'string', 'regex:/^[A-Za-z\s\.\']+$/u', 'max:100'],
            'email'    => ['required', 'email:rfc', 'max:255', Rule::unique('users', 'email')->ignore($id)],
            'phone'    => ['required', 'string', 'regex:/^[0-9]+$/', 'min:10', 'max:15'],
            'kelas'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in($rolesDiizinkan)],
            'is_active'=> ['nullable', 'boolean'],
            'photo'    => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'password' => [$id ? 'nullable' : 'required', 'string', 'min:8', 'max:72'],
        ];
    }

    public function messages(): array
    {
        return [
            'identity.regex' => 'Nomor induk hanya boleh berisi angka.',
            'name.regex'     => 'Nama hanya boleh berisi huruf dan spasi.',
            'phone.regex'    => 'Nomor telepon hanya boleh berisi angka.',
            'role.in'        => 'Anda tidak berwenang menetapkan peran tersebut.',
            'photo.mimes'    => 'Format foto hanya boleh JPG, JPEG, atau PNG.',
            'photo.max'      => 'Ukuran foto maksimal 2 MB.',
            'password.min'   => 'Kata sandi minimal 8 karakter.',
        ];
    }
}
