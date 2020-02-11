<?php

namespace RentRecommender\Utility;

class HtmlDownloader
{
    /**
     * @param string $targetUrl
     * @param string $downloadTo
     * @return bool
     */
    public static function download(string $targetUrl, string $downloadTo): bool
    {
        $html = file_get_contents($targetUrl);
        if ($html) {
            $file = fopen($downloadTo, 'w');
            fwrite($file, $html);
            fclose($file);
        }
        return (bool)$html;
    }
}