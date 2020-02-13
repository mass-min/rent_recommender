<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\HtmlDownloader;
use SplFileObject;

class DetailPageDownloader
{
    const SUUMO_BASE_URL = 'https://suumo.jp';

    private $detailLinksCsvFilePath;
    private $detailPageHtmlDirPath;

    public function __construct($date)
    {
        $this->detailLinksCsvFilePath = DirectoryOperator::getDetailLinksCsvDirPath($date) . '/detailLink.csv';
        $this->detailPageHtmlDirPath = DirectoryOperator::getDetailHtmlDirPath($date);
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $csvFile = new SplFileObject($this->detailLinksCsvFilePath, 'r');
        $csvFile->setFlags(SplFileObject::READ_CSV);

        // HTMLファイル保存用ディレクトリがなかったら作成
        DirectoryOperator::findOrCreate($this->detailPageHtmlDirPath);

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
        $filePath = $this->detailPageHtmlDirPath . '/detail_' . $pageIndex . '.html';

        HtmlDownloader::download($url, $filePath);
    }
}