<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function correctOption()
    {
        return $this->hasOne(Option::class)->where('is_correct', true);
    }

    public function getUserSubmittedOptionAttribute()
    {
        return $this->hasMany(Submission::class)->where('user_id', auth()->user()->id)->latest()->first()->option;
    }
}
