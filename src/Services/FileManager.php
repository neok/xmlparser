<?php

namespace App\Services;


class FileManager
{
    public function downloadFile(string $url, string $destination = __DIR__ . '/../../data/'): ?string
    {
        $fileName = uniqid('file_', true);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        $output = curl_exec($ch);
        curl_close($ch);

        $path = $destination . $fileName;
        $fp = fopen($path, 'wb');
        $result = fwrite($fp, $output);
        fclose($fp);

        return $result ? $path : null;
    }

    public function isValid(string $file): bool
    {
        return is_file($file);
    }


}
