<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailPageDownloader;

require_once "vendor/autoload.php";

class DownloadDetailPages extends RunnerBase
{
    /**
     * download detail page html
     * @param array $argv
     */
    public function execute(array $argv): void
    {
        $date = isset($argv[1]) ? date($argv[1]) : date('Y-m-d');
        (new DetailPageDownloader($date))->execute();
    }
}

(new DownloadDetailPages())->execute($argv);