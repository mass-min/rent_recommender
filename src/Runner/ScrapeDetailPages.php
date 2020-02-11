<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailPageScraper;

require_once "vendor/autoload.php";

class ScrapeDetailPages extends RunnerBase
{
    /**
     * scrape detail page html
     */
    public function execute(): void
    {
        $detailHtmlDirPath = 'tmp/detailHtml';
        $detailHtmlPaths = glob($detailHtmlDirPath . '/*');
        foreach ($detailHtmlPaths as $detailHtmlPath) {
            (new DetailPageScraper())->execute($detailHtmlPath);
        }
    }
}

(new ScrapeDetailPages())->execute();