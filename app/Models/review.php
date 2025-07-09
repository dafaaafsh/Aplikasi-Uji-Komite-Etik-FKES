<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'protokol_id',
        'hasil',
        'catatan',
        'lampiran',
    ];

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function protokol()
    {
        return $this->belongsTo(protocols::class, 'protokol_id');
    }
}

