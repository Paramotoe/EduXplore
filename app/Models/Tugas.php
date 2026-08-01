<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    // Baris inilah yang diminta oleh error tersebut
    protected $fillable = ['id_mapel', 'judul_tugas', 'deskripsi'];

    public function mapel() 
    { 
        return $this->belongsTo(MataPelajaran::class, 'id_mapel', 'id_mapel'); 
    }
    
    public function pengumpulan() 
    { 
        return $this->hasMany(Pengumpulan::class, 'id_tugas'); 
    }
}