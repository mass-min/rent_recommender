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

        foreach ($csvFile as $index => $line) {
            if ($index > 0 && !$csvFile->eof()){
                $url = self::SUUMO_BASE_URL . $line[1];
                $filePath = self::DOWNLOAD_DIR_PATH . '/detail_' . $index . '.html';

                HtmlDownloader::download($url, $filePath);

                sleep(1);
                echo "progress: " . $index . '/' . $totalCount . "\n";
            }
        }
    }
}