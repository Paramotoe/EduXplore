<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi', 'id_guru'];
    public function guru() { return $this->belongsTo(User::class, 'id_guru'); }
}