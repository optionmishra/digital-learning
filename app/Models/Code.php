<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function standards()
    {
        return $this->belongsToMany(Standard::class, 'code_standards')->withTimestamps();
    }

    public function assignStandards($standards)
    {
        $this->standards()->sync($standards);
    }
}
