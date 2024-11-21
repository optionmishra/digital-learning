<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContentType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function media()
    // {
    //     return $this->hasMany(ContentTypeMedia::class);
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($contentType) {
    //         foreach ($contentType->media as $media) {
    //             $dir = $media->type == 'img' ? 'contentTypes/img/' : 'contentTypes/vid/';
    //             // Delete the file from storage
    //             Storage::disk('public')->delete($dir . $media->file);

    //             // Delete the media record
    //             $media->delete();
    //         }
    //     });
    // }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    public function classContents()
    {
        return $this->hasMany(Content::class)->where('standard_id', auth()->user()->profile->standard_id);
    }
}
