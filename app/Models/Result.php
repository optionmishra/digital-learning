<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function attempt()
    {
        return $this->belongsTo(Attempt::class);
    }

    public function assessment()
    {
        return $this->hasOneThrough(Assessment::class, Attempt::class, 'id', 'id', 'attempt_id', 'assessment_id');
    }
}
