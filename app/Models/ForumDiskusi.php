<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ForumDiskusi extends Model
{
    protected $table = 'forum_diskusi';
    protected $primaryKey = 'id_forum';
    protected $fillable = ['id_pembuat', 'pesan'];
    public function user() { return $this->belongsTo(User::class, 'id_pembuat'); }
}