<?php

namespace RentRecommender;

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
        $totalCount = count(glob(self::INDEX_HTML_DIR . '/*'));

        // CSVファイル保存用ディレクトリがなかったら作成
        if (!file_exists(self::DETAIL_LINK_DIR)) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir(self::DETAIL_LINK_DIR, 0777, true);
            echo "Complete to creating tmp directory.\n";
        }

        for ($index = 1; $index <= $totalCount; $index++) {
            $indexHtmlFile = self::INDEX_HTML_DIR . "/index_$index.html";
            $detailLinks = $this->getDetailLinks($indexHtmlFile);

            $csvFileName = self::DETAIL_LINK_DIR . "/detail_$index.csv";
            $this->createDetailLinkCsv($detailLinks, $csvFileName);

            echo "progress: " . $index . '/' . $totalCount . "\n";
        }
    }

    /**
     * @param string $indexHtmlFileName
     * @return array
     */
    private function getDetailLinks(string $indexHtmlFileName): array
    {
        $domIndexPage = \phpQuery::newDocumentFileHTML($indexHtmlFileName);
        $detailLinkElements = $domIndexPage->find('.property_inner-title');

        $detailLinks = [];
        foreach ($detailLinkElements as $detailLinkElement) {
            $detailLinks[] = pq($detailLinkElement)->find('a')->attr('href');
        }

        return $detailLinks;
    }

    /**
     * @param array $detailLinks
     * @param string $csvFileName
     */
    private function createDetailLinkCsv($detailLinks, $csvFileName): void
    {
        $csvFile = new SplFileObject($csvFileName, 'w');
        $csvFile->fputcsv(['path']);

        foreach ($detailLinks as $detailLink) {
            $csvFile->fputcsv([$detailLink]);
        }
    }
}