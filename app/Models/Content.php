<?php

namespace App\Models;

use App\Models\Scopes\UserContentScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Content extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::addGlobalScope(new UserContentScope);
    }

    public function standard()
    {
        return $this->belongsTo(Standard::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    // public function media()
    // {
    //     return $this->hasMany(ContentMedia::class);
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($content) {
    //         foreach ($content->media as $media) {
    //             $dir = $media->type == 'img' ? 'contents/img/' : 'contents/vid/';
    //             // Delete the file from storage
    //             Storage::disk('public')->delete($dir . $media->file);

    //             // Delete the media record
    //             $media->delete();
    //         }
    //     });
    // }
}
