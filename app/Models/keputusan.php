<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class keputusan extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'protokol_id',
        'hasil_akhir',
        'komentar',
        'jenis_penerimaan',
        'lampiran',
        'path',
        
    ];

    public function protokol(): BelongsTo{
        return $this->belongsTo(protocols::class,'protokol_id');
    }
    
}
