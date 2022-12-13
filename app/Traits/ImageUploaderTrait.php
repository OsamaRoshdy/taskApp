<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

trait ImageUploaderTrait
{
    public function storeImage($file, $location): string
    {
        if (!$file) return 'default.png';

        Image::make($file)
            ->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        $file->store('images/' . $location , 'public');

        return $file->hashName();
    }

    public function updateImage($newFile, $oldFile, $location): ?string
    {
        $this->deleteImage($oldFile, $location);
        return $this->storeImage($newFile, $location);
    }

    public function deleteImage($fileName, $location): bool
    {
        return $fileName === 'default.png' || Storage::disk('public')->delete('images/' . $location . '/' . $fileName);
    }
}
