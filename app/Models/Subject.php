<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($subject) {
            $dir = 'subjects/img/';
            // Delete the file from storage
            Storage::disk('public')->delete($dir . $subject->img);
        });
    }

    public function standards()
    {
        return $this->belongsToMany(Standard::class, 'standard_subjects');
    }
}
