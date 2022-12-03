<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'kriteria';

    public $timestamps = false;

    public function indikator()
    {
        return $this->hasMany(Indikator::class, 'id_kriteria');
    }
}
