<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kepala_sekolah';

    public $timestamps = false;

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }

    public function nilai_kepsek()
    {
        return $this->hasMany(NilaiKepsek::class, 'id_kepala_sekolah');
    }
}
