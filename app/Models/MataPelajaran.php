<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';
    protected $primaryKey = 'id_mapel';
    protected $fillable = ['nama_mapel', 'id_guru'];

    public function guru() { return $this->belongsTo(User::class, 'id_guru'); }
    public function tugas() { return $this->hasMany(Tugas::class, 'id_mapel', 'id_mapel'); }
}