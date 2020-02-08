<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class IndexPagesDownloader
{
    /**
     * main function
     */
    public function execute(): void
    {
        $this->beforeAction();

        $crawler = new IndexPageCrawler();
        $crawler->execute();

        $this->afterAction();
    }

    /**
     * function executed before executing run()
     * @return void
     */
    protected function beforeAction(): void
    {
        echo "--- IndexPagesDownloader start ---\n";
    }

    /**
     * function executed after executing run()
     * @return void
     */
    protected function afterAction(): void
    {
        echo "--- IndexPagesDownloader Finish ---\n";
    }
}

$downloadIndexPages = new IndexPagesDownloader();
$downloadIndexPages->execute();