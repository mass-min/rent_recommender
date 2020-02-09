<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class DownloadDetailPages
{
    /**
     * main function
     * @return void
     */
    public function execute(): void
    {
        $this->beforeAction();

        $csvFileName = 'tmp/detailLinks/detail_1.csv';
        $downloader = new DetailPageDownloader();
        $downloader->execute($csvFileName);

        $this->afterAction();
    }

    /**
     * function executed before running execute()
     * @return void
     */
    protected function beforeAction(): void
    {
        echo "--- DownloadDetailPages start ---\n";
    }

    /**
     * function executed after running execute()
     * @return void
     */
    protected function afterAction(): void
    {
        echo "--- DownloadDetailPages Finish ---\n";
    }
}

$downloadDetailPages = new DownloadDetailPages();
$downloadDetailPages->execute();