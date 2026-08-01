<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumpulan extends Model
{
    // Mengizinkan kolom ini diisi
    protected $fillable = ['id_tugas', 'id_siswa', 'jawaban_atau_link', 'nilai'];

    // Relasi ke tabel User (Siswa)
    public function siswa() 
    { 
        return $this->belongsTo(User::class, 'id_siswa'); 
    }

    // INI DIA TAMBAHANNYA: Relasi ke tabel Tugas
    public function tugas() 
    { 
        return $this->belongsTo(Tugas::class, 'id_tugas'); 
    }
}