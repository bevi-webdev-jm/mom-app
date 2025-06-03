<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class FileSavingHelper {

    public static function saveFile($file, $id, $module)
    {
        // Define the relative path
        $relativePath = "{$module}/{$id}";

        // Ensure the directory exists and set permissions
        $fullPath = public_path("uploads/{$relativePath}");
        if(!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
            chmod($fullPath, 0755);
        }

        // Generate a unique filename
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move file using Laravel's Storage (public disk)
        $path = $file->storeAs($relativePath, $filename, 'uploads');

        // Return the saved file path
        return "uploads/" . $path;
    }

    public static function deleteFile($path) {
        // Strip the "uploads/" prefix if present
        $cleanPath = str_replace('uploads/', '', $path);

        // Delete the file using the 'uploads' disk
        return Storage::disk('uploads')->delete($cleanPath);
    }

}