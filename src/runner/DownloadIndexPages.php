<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class DownloadIndexPages
{
    /**
     * main function
     * @return void
     */
    public function execute(): void
    {
        $this->beforeAction();

        $crawler = new IndexPageCrawler();
        $crawler->execute();

        $this->afterAction();
    }

    /**
     * function executed before running execute()
     * @return void
     */
    protected function beforeAction(): void
    {
        echo "--- DownloadIndexPages start ---\n";
    }

    /**
     * function executed after running execute()
     * @return void
     */
    protected function afterAction(): void
    {
        echo "--- DownloadIndexPages Finish ---\n";
    }
}

$downloadIndexPages = new DownloadIndexPages();
$downloadIndexPages->execute();