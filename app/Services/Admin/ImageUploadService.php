<?php

namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload an image file to the specified folder.
     */
    public function upload(UploadedFile $file, string $folder, int $maxWidth = 1920): string
    {
        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/{$folder}/{$filename}";

        Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));

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
