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
        $detailHtmlDirPath = 'tmp/detailHtml';
        $detailHtmlPaths = glob($detailHtmlDirPath . '/*');
        foreach ($detailHtmlPaths as $detailHtmlPath) {
            (new DetailPageScraper())->execute($detailHtmlPath);
        }
    }
}

(new ScrapeDetailPages())->execute($argv);