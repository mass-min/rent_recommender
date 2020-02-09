<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class GetDetailPageLinks
{
    /**
     * main function
     */
    public function execute(): void
    {
        $this->beforeAction();

        $detailLinkGetter = new DetailLinkGetter();
        $detailLinkGetter->execute();

        $this->afterAction();
    }

    /**
     * function executed before running execute()
     * @return void
     */
    protected function beforeAction(): void
    {
        echo "--- GetDetailPageLinks start ---\n";
    }

    /**
     * function executed after running execute()
     * @return void
     */
    protected function afterAction(): void
    {
        echo "--- GetDetailPageLinks Finish ---\n";
    }
}

$getDetailPageLinks = new GetDetailPageLinks();
$getDetailPageLinks->execute();