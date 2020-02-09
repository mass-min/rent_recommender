<?php

namespace RentRecommender;

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
        if (!file_exists(self::DOWNLOAD_DIR_PATH)) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir(self::DOWNLOAD_DIR_PATH, 0777, true);
            echo "Complete to creating tmp directory.\n";
        }

        // CSVファイルの総行数を取得
        $csvFile->seek(PHP_INT_MAX);
        $totalCount = $csvFile->key(); // keyは0から始まるがヘッダー行があるので +1 はしない
        $csvFile->seek(1); // 1行目に移動(ヘッダーの下)

        foreach ($csvFile as $index => $line) {
            $url = self::SUUMO_BASE_URL . $line[0];
            $fileName = self::DOWNLOAD_DIR_PATH . '/detail_' . $index . '.html';

            $pageDownloader = new PageDownloader();
            $pageDownloader->download($url, $fileName);

            sleep(1);
            echo "progress: " . ($index + 1) . '/' . $totalCount . "\n";
        }
    }
}