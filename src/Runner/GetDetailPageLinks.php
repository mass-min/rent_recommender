<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailLinkGetter;

require_once "vendor/autoload.php";

class GetDetailPageLinks extends RunnerBase
{
    /**
     * download detail page links csv
     * @param array $argv
     */
    public function execute(array $argv): void
    {
        $date = date($argv[1]) ?: date('Y-m-d');
        (new DetailLinkGetter($date))->execute();
    }
}

// php src/Runner/GetDetailPageLinks.php `date "+%Y-%m-%d"`
(new GetDetailPageLinks())->execute($argv);