<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['file_name'];
    public $timestamps = false;

    public function delete()
    {
        $files = Storage::allFiles('public/pdf_files');
        Storage::delete($files);
        parent::delete();
    }
}
