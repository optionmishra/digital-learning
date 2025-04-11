<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Series extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function media()
    // {
    //     return $this->hasMany(SeriesMedia::class);
    // }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::deleting(function ($series) {
    //         foreach ($series->media as $media) {
    //             $dir = $media->type == 'img' ? 'seriess/img/' : 'seriess/vid/';
    //             // Delete the file from storage
    //             Storage::disk('public')->delete($dir . $media->file);

    //             // Delete the media record
    //             $media->delete();
    //         }
    //     });
    // }
}
