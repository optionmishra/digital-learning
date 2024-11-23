<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
