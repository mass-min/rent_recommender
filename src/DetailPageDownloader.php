<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\HtmlDownloader;
use SplFileObject;

class DetailPageDownloader
{
    const DOWNLOAD_DIR_PATH = 'tmp/detailHtml';
    const SUUMO_BASE_URL = 'https://suumo.jp';

    /**
     * @param string $DetailLinksCsvFileName
     * @return void
     */
    public function execute(string $DetailLinksCsvFileName): void
    {
        $csvFile = new SplFileObject($DetailLinksCsvFileName, 'r');
        $csvFile->setFlags(SplFileObject::READ_CSV);

        // HTMLファイル保存用ディレクトリがなかったら作成
        DirectoryOperator::findOrCreate(self::DOWNLOAD_DIR_PATH);

        // CSVファイルの総行数を取得
        $csvFile->seek(PHP_INT_MAX);
        $totalCount = $csvFile->key() - 1; // ヘッダー行を除くので -1

        // 詳細ページのHTMLファイルをダウンロード
        foreach ($csvFile as $index => $line) {
            if ($index > 0 && !$csvFile->eof()){
                $this->downloadDetailHtml($line[1], $index);
                sleep(1);
                echo "progress: " . $index . '/' . $totalCount . "\n";
            }
        }
    }

    /**
     * @param string $path
     * @param int $pageIndex
     */
    public function downloadDetailHtml(string $path, int $pageIndex): void
    {
        $url = self::SUUMO_BASE_URL . $path;
        $filePath = self::DOWNLOAD_DIR_PATH . '/detail_' . $pageIndex . '.html';

        HtmlDownloader::download($url, $filePath);
    }
}