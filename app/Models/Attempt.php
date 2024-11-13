<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attempt extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
