<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function questionTypes()
    {
        return $this->hasManyThrough(
            QuestionType::class,
            Question::class,
            'topic_id', // Foreign key on questions table
            'id', // Local key on question_types table
            'id', // Local key on topics table
            'question_type_id' // Foreign key on questions table
        );
    }
}
