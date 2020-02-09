<?php

namespace RentRecommender;

class PageDownloader
{
    /**
     * @param string $url
     * @param string $fileName
     * @return bool
     */
    public function download(string $url, string $fileName): bool
    {
        $indexPage = file_get_contents($url);
        if ($indexPage) {
            $file = fopen($fileName, 'w');
            fwrite($file, $indexPage);
            fclose($file);
        }
        return (bool)$indexPage;
    }
}