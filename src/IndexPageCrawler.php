<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\DocumentInitializer;
use RentRecommender\Utility\HtmlDownloader;

class IndexPageCrawler
{
    // 目黒区/賃料が安い順/30件ずつ
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po2=99&po1=00';

    private $downloadDirPath;

    /**
     * IndexPageCrawler constructor.
     */
    public function __construct($date)
    {
        $this->indexHtmlDirPath = DirectoryOperator::getIndexHtmlDirPath($date);
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        // HTMLファイル保存用ディレクトリがなかったら作成
        DirectoryOperator::findOrCreate($this->indexHtmlDirPath);

        // indexページの総ページ数取得
        $pageCount = $this->getTotalPage(self::INDEX_URL);

        // 各indexページのhtmlを取得
        for ($pageIndex = 1; $pageIndex <= $pageCount; $pageIndex++) {
            $this->downloadIndexHtml($pageIndex);
            sleep(1);
            echo "progress: " . $pageIndex . '/' . $pageCount . "\n";
        }
    }

    /**
     * @param string $indexHtmlUrl
     * @return int
     */
    private function getTotalPage(string $indexHtmlUrl): int
    {
        // ページネーションの最後の数字から総ページ数を取得
        $doc = DocumentInitializer::createDocumentWithHtml($indexHtmlUrl);
        $pageCount = $doc->find('.pagination-parts > li:last-child a')->text();
        echo 'total page count: ' . $pageCount . "\n";

        return (int)$pageCount;
    }

    /**
     * @param $pageIndex
     * @return void
     */
    private function downloadIndexHtml($pageIndex): void
    {
        $url = self::INDEX_URL . '&page=' . $pageIndex;
        $filePath = $this->indexHtmlDirPath . '/index_' . $pageIndex . '.html';
        HtmlDownloader::download($url, $filePath);
    }
}