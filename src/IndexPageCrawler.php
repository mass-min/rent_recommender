<?php

namespace RentRecommender;

use DOMWrap\Document;

class IndexPageCrawler
{
    // 目黒区/賃料が安い順/30件ずつ
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po2=99&po1=00';
    const DOWNLOAD_DIR_PATH = 'tmp/indexHtml';

    /**
     * @return void
     */
    public function execute(): void
    {
        // indexページの総ページ数取得
        $indexPage = file_get_contents(self::INDEX_URL);
        $pageCount = $this->getTotalPage($indexPage);

        // HTMLファイル保存用ディレクトリがなかったら作成
        if (!file_exists(self::DOWNLOAD_DIR_PATH)) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir(self::DOWNLOAD_DIR_PATH, 0777, true);
            echo "Complete to creating tmp directory.\n";
        }

        // 各indexページのhtmlを取得
        for ($pageIndex = 1; $pageIndex <= $pageCount; $pageIndex++) {
            $url = self::INDEX_URL . '&page=' . $pageIndex;
            $filePath = self::DOWNLOAD_DIR_PATH . '/index_' . $pageIndex . '.html';

            $pageDownloader = new PageDownloader();
            $pageDownloader->download($url, $filePath);

            sleep(1);
            echo "progress: " . $pageIndex . '/' . $pageCount . "\n";
        }
    }

    /**
     * @param $indexPageHtml
     * @return int
     */
    private function getTotalPage($indexPageHtml): int
    {
        // ページネーションの最後の数字から総ページ数を取得
        $doc = new Document();
        $doc->html($indexPageHtml);
        $pageCount = $doc->find('.pagination-parts > li:last-child a')->text();
        echo 'total page count: ' . $pageCount . "\n";
        return (int)$pageCount;
    }
}