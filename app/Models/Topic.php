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

    public function contentTypes()
    {
        return $this->hasManyThrough(
            ContentType::class,
            Content::class,
            'topic_id', // Foreign key on contents table
            'id', // Local key on content_types table
            'id', // Local key on topics table
            'content_type_id' // Foreign key on contents table
        );
    }

    public function getUniqueAvailableContentTypesAttribute()
    {
        $user = auth()->user();
        return $this->contentTypes()
            ->distinct('name')
            ->where(function ($query) use ($user) {
                $query->whereNull('role_id')->orWhere('role_id', $user->roles[0]->id);
            })->get();
    }
}
