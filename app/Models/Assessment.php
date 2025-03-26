<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            table: 'assessment_questions',
        )->withTimestamps();
    }

    public function results()
    {
        return $this->hasManyThrough(Result::class, Attempt::class, 'assessment_id', 'attempt_id');
    }

    public function getLatestAttemptAttribute()
    {
        return $this->hasMany(Attempt::class)->latest()->first();
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }
}
