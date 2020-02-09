<?php

namespace RentRecommender;

use SplFileObject;

class DetailPageDownloader
{
    const DOWNLOAD_DIR_PATH = 'tmp/detailLinks';
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

        foreach ($csvFile as $index => $line) {
            if ($index == 0) {
                continue;
            }
            $url = self::SUUMO_BASE_URL . $line;
            $fileName = self::DOWNLOAD_DIR_PATH . '/detail_' . $line . '.html';

            $pageDownloader = new PageDownloader();
            $pageDownloader->download($url, $fileName);

            sleep(1);
            echo "progress: " . $index . '/' . $csvFile->getMaxLineLen() . "\n";
        }
    }
}