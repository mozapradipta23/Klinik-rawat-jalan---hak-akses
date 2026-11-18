<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $table      = 'poli';
    protected $primaryKey = 'id_poli';
    public $timestamps    = false;

    protected $fillable = ['nama_poli'];

    public function dokter(): HasMany
    {
        return $this->hasMany(Dokter::class, 'id_poli', 'id_poli');
    }
}
