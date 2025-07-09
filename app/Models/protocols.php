<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class protocols extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'judul',
        'subjek_penelitian',
        'jenis_penelitian',
        'jenis_pengajuan',
        'biaya_penelitian',
        'status_penelitian',
        'nomor_protokol',
        'nomor_protokol_asli',
        'tanggal_pengajuan',
        'verified_pembayaran',
        'path_pembayaran',
        'status_pembayaran',
        'kategori_review',
        'status_telaah',
        'komentar',
        'tarif',
    ];

    public function peneliti(): BelongsTo{
        return $this->belongsTo(User::class,'user_id');
    }

    public function putusan(): HasOne{
        return $this->hasOne(keputusan::class,'protokol_id');
    }

    public function review(): HasMany{
        return $this->hasMany(review::class, 'protokol_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class,'protocol_id');
    }
}
