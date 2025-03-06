<?php

namespace App\Utils;

class FileUtils {

     public static function convertToBase64(string $filePath): ?string
    {
        $imageData = base64_encode(file_get_contents($filePath));
        $mimeType = mime_content_type($filePath);

        return "data:$mimeType;base64,$imageData";
    }
}
