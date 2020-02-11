<?php

namespace RentRecommender\Runner;

use RentRecommender\IndexPageCrawler;

require_once "vendor/autoload.php";

class DownloadIndexPages extends RunnerBase
{
    /**
     * download index page html
     */
    public function execute(): void
    {
        (new IndexPageCrawler())->execute();
    }
}

(new DownloadIndexPages())->execute();