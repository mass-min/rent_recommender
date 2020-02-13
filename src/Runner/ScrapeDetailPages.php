<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailPageScraper;

require_once "vendor/autoload.php";

class ScrapeDetailPages extends RunnerBase
{
    /**
     * scrape detail page html
     * @param array $argv
     */
    public function execute(array $argv): void
    {
        $date = isset($argv[1]) ? date($argv[1]) : date('Y-m-d');
        (new DetailPageScraper($date))->execute();
    }
}

(new ScrapeDetailPages())->execute($argv);