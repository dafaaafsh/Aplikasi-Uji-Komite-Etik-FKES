<?php

namespace App\Models;

use App\Models\protocols;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    protected $fillable = ['protocol_id', 'tipe_file', 'nama_file'];

    public function protocol()
    {
        return $this->belongsTo(protocols::class);
    }
}
