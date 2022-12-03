<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Normalisasi extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'normalisasi';

    public $timestamps = false;

    public function nilai_kepsek()
    {
        return $this->belongsTo(NilaiKepsek::class, 'id_nilai_kepsek');
    }
}
