<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKepsek extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'nilai_kepsek';

    public $timestamps = false;

    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'id_indikator', 'id');
    }

    public function kepsek()
    {
        return $this->belongsTo(KepalaSekolah::class, 'id_kepala_sekolah');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'id_periode');
    }

    public function normaliasi()
    {
        return $this->hasOne(Normalisasi::class, 'id_nilai_kepsek');
    }
}
