<?php

namespace RentRecommender\Runner;

use RentRecommender\DetailLinkGetter;

require_once "vendor/autoload.php";

class GetDetailPageLinks extends RunnerBase
{
    /**
     * download detail page links csv
     */
    public function execute(): void
    {
        (new DetailLinkGetter())->execute();
    }
}

(new GetDetailPageLinks())->execute();