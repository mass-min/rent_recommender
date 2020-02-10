<?php

namespace RentRecommender;

use SplFileObject;
use DOMWrap\Document;

class DetailLinkGetter
{
    const INDEX_HTML_DIR = 'tmp/indexHtml';
    const DETAIL_LINK_DIR = 'tmp/detailLinks';

    /**
     * @return void
     */
    public function execute(): void
    {
        $totalCount = count(glob(self::INDEX_HTML_DIR . '/*'));

        // CSVファイル保存用ディレクトリがなかったら作成
        if (!file_exists(self::DETAIL_LINK_DIR)) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir(self::DETAIL_LINK_DIR, 0777, true);
            echo "Complete to creating tmp directory.\n";
        }

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
        $indexHtml = file_get_contents($indexHtmlFilePath);
        $doc = new Document();
        $doc->html($indexHtml);
        $detailLinkElements = $doc->find('.property_inner-title');

        $detailLinks = [];
        foreach ($detailLinkElements as $detailLinkElement) {
            $detailLinks[] = $detailLinkElement->find('a')->attr('href');
        }

        return $detailLinks;
    }

    /**
     * @param array $detailLinks
     * @param string $csvFilePath
     */
    private function createDetailLinkCsv($detailLinks, $csvFilePath): void
    {
        $csvFile = new SplFileObject($csvFilePath, 'w');
        $csvFile->fputcsv(['path']);

        foreach ($detailLinks as $detailLink) {
            $csvFile->fputcsv([$detailLink]);
        }
    }
}