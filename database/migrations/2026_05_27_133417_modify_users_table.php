<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menyesuaikan tabel users bawaan Laravel dengan kebutuhan
 * Sistem Informasi Pembelajaran EduXplore (SMA/SMK).
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Nomor Induk (NIM/NIS untuk siswa, NIP untuk guru & tenaga kependidikan)
            $table->string('identity', 20)->unique()->after('email');
            $table->string('phone', 15)->nullable()->after('identity');
            $table->string('photo')->nullable()->after('phone');
            $table->string('kelas', 20)->nullable()->after('photo');
            $table->enum('role', ['super_admin', 'admin', 'guru', 'siswa'])
                  ->default('siswa')->after('kelas');
            $table->boolean('is_active')->default(true)->after('role');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->string('last_login_ip', 45)->nullable()->after('last_login_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'identity', 'phone', 'photo', 'kelas',
                'role', 'is_active', 'last_login_at', 'last_login_ip',
            ]);
        });
    }
};
