<?php
namespace App\Services;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageService
{
    public function optimizeAndStore($file, $folder = 'vehicles')
    {
        $extension = 'webp';
        $filename = Str::random(20) . '.' . $extension;
        $path = $folder . '/' . $filename;

        $image = Image::make($file)
            ->resize(1200, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->encode('webp', 85);

        \Storage::disk('public')->put($path, $image);

        return $path;
    }

    public function makeThumbnail($sourcePath, $folder = 'vehicles/thumbs')
    {
        $filename = pathinfo($sourcePath, PATHINFO_FILENAME) . '_thumb.webp';
        $thumbPath = $folder . '/' . $filename;

        $image = Image::make(public_path('storage/' . $sourcePath))
            ->resize(300, 200)
            ->encode('webp', 80);

        \Storage::disk('public')->put($thumbPath, $image);

        return $thumbPath;
    }
}