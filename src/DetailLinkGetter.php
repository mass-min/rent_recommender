<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\DocumentInitializer;
use SplFileObject;

class DetailLinkGetter
{
    private $detailLinkCsvDirPath;
    private $indexHtmlDirPath;

    public function __construct(string $date)
    {
        $this->detailLinkCsvDirPath = DirectoryOperator::getDetailLinksCsvDirPath($date);
        $this->indexHtmlDirPath = DirectoryOperator::getIndexHtmlDirPath($date);
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        // CSVファイル保存用ディレクトリがなかったら作成
        DirectoryOperator::findOrCreate($this->detailLinkCsvDirPath);

        $totalCount = count(glob($this->indexHtmlDirPath . '/*'));

        for ($index = 1; $index <= $totalCount; $index++) {
            $indexHtmlFilePath = $this->indexHtmlDirPath . "/index_$index.html";
            $detailLinks = $this->getDetailLinks($indexHtmlFilePath);

            $csvFilePath = $this->detailLinkCsvDirPath . "/detailLink.csv";
            $this->addDetailLinkToCsv($detailLinks, $csvFilePath);

            echo "progress: " . $index . '/' . $totalCount . "\n";
        }
    }

    /**
     * @param string $indexHtmlFilePath
     * @return array
     */
    private function getDetailLinks(string $indexHtmlFilePath): array
    {
        $doc = DocumentInitializer::createDocumentWithHtml($indexHtmlFilePath);
        $detailLinkElements = $doc->find('.property_inner-title');

        $detailLinks = [];
        foreach ($detailLinkElements as $detailLinkElement) {
            $title = trim($detailLinkElement->nodeValue);
            $path = $detailLinkElement->lastChild->attr('href');
            $detailLinks[$title] = $path;
        }

        return $detailLinks;
    }

    /**
     * @param array $detailPages
     * @param string $csvFilePath
     */
    private function addDetailLinkToCsv($detailPages, $csvFilePath): void
    {
        $csvFile = new SplFileObject($csvFilePath, 'a+');
        $csvFile->seek(PHP_INT_MAX);
        if ($csvFile->key() == 0) {
            $csvFile->fputcsv(['name', 'path']);
        }
        foreach ($detailPages as $title => $path) {
            $csvFile->fputcsv([$title, $path]);
        }
    }
}