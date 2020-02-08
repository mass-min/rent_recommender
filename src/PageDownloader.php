<?php

namespace RentRecommender;

class PageDownloader
{
    /**
     * @param $url
     * @param $fileName
     * @return void
     */
    public function download($url, $fileName): void
    {
        $indexPage = file_get_contents($url);
        $file = fopen($fileName, 'w');
        fwrite($file, $indexPage);
        fclose($file);
    }
}