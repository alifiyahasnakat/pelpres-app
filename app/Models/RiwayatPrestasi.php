<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPrestasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nisn',
        'kelas',
        'angkatan',
        'kompetisi',
        'juara',
        'tingkat',
        'poin',
        'keterangan',
        'created_by',
        'created_at',
    ];
    public function getAuthIdentifierName()
    {
        return 'id';
    }

}
