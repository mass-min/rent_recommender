<?php

namespace RentRecommender;

class PageDownloader
{
    /**
     * @param string $url
     * @param string $filePath
     * @return bool
     */
    public function download(string $url, string $filePath): bool
    {
        $indexPage = file_get_contents($url);
        if ($indexPage) {
            $file = fopen($filePath, 'w');
            fwrite($file, $indexPage);
            fclose($file);
        }
        return (bool)$indexPage;
    }
}