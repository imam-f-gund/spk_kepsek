<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'periode';

    public $timestamps = false;

    public function nilai_kepsek()
    {
        return $this->hasMany(NilaiKepsek::class, 'id_periode');
    }
}
