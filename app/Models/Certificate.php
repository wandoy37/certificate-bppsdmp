<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function penandatangan()
    {
        return $this->belongsTo(Penandatangan::class);
    }
}
