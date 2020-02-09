<?php

namespace RentRecommender;

class IndexPageCrawler
{
    // 目黒区/賃料が安い順/30件ずつ
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po2=99&po1=00';

    /**
     * @return void
     */
    public function execute(): void
    {
        // indexページの総ページ数取得
        $indexPage = file_get_contents(self::INDEX_URL);
        $pageCount = $this->getTotalPage($indexPage);

        // HTMLファイル保存用ディレクトリがなかったら作成
        if (!file_exists('tmp')) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir('tmp');
            echo "Complete to creating tmp directory.\n";
        }

        // 各indexページのhtmlを取得
        for ($pageIndex = 1; $pageIndex <= $pageCount; $pageIndex++) {
            $url = self::INDEX_URL . '&page=' . $pageIndex;
            $fileName = 'tmp/index_' . $pageIndex . '.html';

            $pageDownloader = new PageDownloader();
            $pageDownloader->download($url, $fileName);

            sleep(1);
            echo "progress: " . $pageIndex . '/' . $pageCount . "\n";
        }
    }

    /**
     * @param $handle
     * @return int
     */
    private function getTotalPage($handle): int
    {
        // ページネーションの最後の数字から総ページ数を取得
        $domIndexPage = \phpQuery::newDocument($handle);
        $pageCount = (int)$domIndexPage->find('.pagination-parts > li:last-child a')->text();
        echo 'total page count: ' . $pageCount . "\n";
        return $pageCount;
    }
}