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

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }
    public function assessment()
    {
        return $this->belongsToMany(Assessment::class, 'assessment_questions')->withTimestamps();
    }
}
