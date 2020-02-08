<?php

require 'vendor/autoload.php';

class Crawler
{
    // 目黒区/賃料が安い順/30件ずつ
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po2=99&po1=00';

    /**
     * function executed before executing run()
     * @return void
     */
    protected function beforeAction()
    {
        echo "--- Crawler start ---\n";
        if (!file_exists('tmp')) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir('tmp');
            echo "Complete to creating tmp directory.\n";
        }
    }

    /**
     * @return void
     */
    public function run()
    {
        self::beforeAction();

        // indexページの総ページ数取得
        $indexPage = file_get_contents(self::INDEX_URL);
        $pageCount = self::getTotalPage($indexPage);

        // 各indexページのhtmlを取得
        for ($pageIndex = 1; $pageIndex < $pageCount; $pageIndex++) {
            $indexPage = file_get_contents(self::INDEX_URL . '&page=' . $pageIndex);
            $file = fopen('tmp/index_' . $pageIndex . '.html', 'w');
            fwrite($file, $indexPage);
            fclose($file);
            sleep(1);
            echo "progress: " . $pageIndex . '/' . $pageCount . "\n";
        }

        self::afterAction();
    }

    /**
     * @param $handle
     * @return int
     */
    private function getTotalPage($handle)
    {
        // ページネーションの最後の数字から総ページ数を取得
        $domIndexPage = phpQuery::newDocument($handle);
        $pageCount = (int)$domIndexPage->find('.pagination-parts > li:last-child a')->text();
        echo 'total page count: ' . $pageCount . "\n";
        return $pageCount;
    }

    /**
     * function executed after executing run()
     * @return void
     */
    protected function afterAction()
    {
        echo "--- Crawler Finish ---\n";
    }
}

$crawler = new Crawler();
$crawler->run();