<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standard extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'standard_subjects');
    }
}
