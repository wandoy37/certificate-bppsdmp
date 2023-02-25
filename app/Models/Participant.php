<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $guarded = [];
    // protected $dates = ['start_date', 'end_date'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'training_id', 'id');
    }
}
