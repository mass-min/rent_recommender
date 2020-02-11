<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailPageDownloader;

require_once "vendor/autoload.php";

class DownloadDetailPages extends RunnerBase
{
    /**
     * download detail page html
     */
    public function execute(): void
    {
        $csvFilePath = 'tmp/detailLinks/detail_1.csv';
        (new DetailPageDownloader())->execute($csvFilePath);
    }
}

(new DownloadDetailPages())->execute();