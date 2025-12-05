<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageOptimizationService
{
    protected ImageManager $manager;
    protected int $maxWidth = 1920;
    protected int $maxHeight = 1080;
    protected int $quality = 85;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    /**
     * Optimize and convert image to WebP format
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param string|null $filename
     * @return string Path to the optimized image
     */
    public function optimizeAndStore(UploadedFile $file, string $directory, ?string $filename = null): string
    {
        // Generate unique filename if not provided
        if (!$filename) {
            $filename = uniqid() . '_' . time();
        }

        // Read and process the image
        $image = $this->manager->read($file->getRealPath());

        // Resize if image is too large (maintain aspect ratio)
        if ($image->width() > $this->maxWidth || $image->height() > $this->maxHeight) {
            $image->scale(width: $this->maxWidth, height: $this->maxHeight);
        }

        // Convert to WebP format
        $webpImage = $image->toWebp($this->quality);

        // Generate storage path
        $path = $directory . '/' . $filename . '.webp';

        // Store the optimized image
        Storage::disk('public')->put($path, (string) $webpImage);

        return $path;
    }

    /**
     * Optimize multiple images
     *
     * @param array $files Array of UploadedFile instances
     * @param string $directory
     * @return array Array of paths to optimized images
     */
    public function optimizeMultiple(array $files, string $directory): array
    {
        $paths = [];

        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $paths[] = $this->optimizeAndStore($file, $directory);
            }
        }

        return $paths;
    }

    /**
     * Set maximum dimensions
     *
     * @param int $width
     * @param int $height
     * @return self
     */
    public function setMaxDimensions(int $width, int $height): self
    {
        $this->maxWidth = $width;
        $this->maxHeight = $height;
        return $this;
    }

    /**
     * Set WebP quality (0-100)
     *
     * @param int $quality
     * @return self
     */
    public function setQuality(int $quality): self
    {
        $this->quality = max(0, min(100, $quality));
        return $this;
    }
}
