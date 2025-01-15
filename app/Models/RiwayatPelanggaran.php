<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPelanggaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'nisn',
        'kelas',
        'angkatan',
        'jenis',
        'poin',
        'kategori',
        'keterangan',
        'created_by',
        'created_at',
    ];
    public function getAuthIdentifierName()
    {
        return 'id';
    }
}
