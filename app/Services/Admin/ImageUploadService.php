<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageUploadService
{
    /**
     * Upload an image file to the specified folder with optional resizing.
     */
    public function upload(UploadedFile $file, string $folder, int $maxWidth = 1920): string
    {
        $filename = uniqid().'_'.time().'.jpg';
        $path = "uploads/{$folder}/{$filename}";

        $image = Image::read($file->getRealPath());

        if ($image->width() > $maxWidth) {
            $image->scaleDown(width: $maxWidth);
        }

        $encoded = $image->toJpeg(85);

        Storage::disk('public')->put($path, (string) $encoded);

        return $path;
    }

    /**
     * Delete an image file from storage.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Replace an existing image with a new one.
     */
    public function replace(?string $oldPath, UploadedFile $file, string $folder, int $maxWidth = 1920): string
    {
        $this->delete($oldPath);

        return $this->upload($file, $folder, $maxWidth);
    }
}
