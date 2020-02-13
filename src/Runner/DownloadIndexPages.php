<?php

namespace RentRecommender\Runner;

use RentRecommender\IndexPageCrawler;

require_once "vendor/autoload.php";

class DownloadIndexPages extends RunnerBase
{
    /**
     * download index page html
     * @param array $argv
     */
    public function execute(array $argv): void
    {
        $date = isset($argv[1]) ? date($argv[1]) : date('Y-m-d');
        (new IndexPageCrawler($date))->execute();
    }
}

(new DownloadIndexPages())->execute($argv);