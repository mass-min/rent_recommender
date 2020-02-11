<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\DocumentInitializer;
use SplFileObject;

class DetailLinkGetter
{
    const INDEX_HTML_DIR = 'tmp/indexHtml';
    const DETAIL_LINK_DIR = 'tmp/detailLinks';

    /**
     * @return void
     */
    public function execute(): void
    {
        // CSVファイル保存用ディレクトリがなかったら作成
        DirectoryOperator::findOrCreate(self::DETAIL_LINK_DIR);

        $totalCount = count(glob(self::INDEX_HTML_DIR . '/*'));

        for ($index = 1; $index <= $totalCount; $index++) {
            $indexHtmlFilePath = self::INDEX_HTML_DIR . "/index_$index.html";
            $detailLinks = $this->getDetailLinks($indexHtmlFilePath);

            $csvFilePath = self::DETAIL_LINK_DIR . "/detail_$index.csv";
            $this->createDetailLinkCsv($detailLinks, $csvFilePath);

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
    private function createDetailLinkCsv($detailPages, $csvFilePath): void
    {
        $csvFile = new SplFileObject($csvFilePath, 'w');
        $csvFile->fputcsv(['title', 'path']);

        foreach ($detailPages as $title => $path) {
            $csvFile->fputcsv([$title, $path]);
        }
    }
}