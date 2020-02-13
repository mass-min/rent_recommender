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
        $date = date($argv[1]) ?: date('Y-m-d');
        (new IndexPageCrawler())->execute($date);
    }
}

(new DownloadIndexPages())->execute($argv);