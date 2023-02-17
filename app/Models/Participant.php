<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
