<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class DetailPageLinksSearcher
{
    /**
     * main function
     */
    public function execute(): void
    {
        $this->beforeAction();

        $detailLinkSearcher = new DetailLinkSearcher();
        $detailLinkSearcher->execute();

        $this->afterAction();
    }

    /**
     * function executed before executing execute()
     * @return void
     */
    protected function beforeAction(): void
    {
        echo "--- DetailPageLinksSearcher start ---\n";
    }

    /**
     * function executed after executing execute()
     * @return void
     */
    protected function afterAction(): void
    {
        echo "--- DetailPageLinksSearcher Finish ---\n";
    }
}

$detailPageLinksSearcher = new DetailPageLinksSearcher();
$detailPageLinksSearcher->execute();