<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use RentRecommender\Utility\DocumentInitializer;
use SplFileObject;

class DetailPageScraper
{
    private $detailPageHtmlDirPath;
    private $detailDataDirPath;

    public function __construct($date)
    {
        $this->detailPageHtmlDirPath = DirectoryOperator::getDetailHtmlDirPath($date);
        $this->detailDataDirPath = DirectoryOperator::getDetailDataCsvDirPath($date);
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $detailHtmlPaths = glob($this->detailPageHtmlDirPath . '/*');

        foreach ($detailHtmlPaths as $index => $detailHtmlPath) {
            $doc = DocumentInitializer::createDocumentWithHtml($detailHtmlPath);
            $data = [];
            $targets = self::scrapingTargets();

            foreach ($targets as $property => $selector) {
                $data[$property] = trim($doc->find($selector)->text());
            }

            // CSVファイル保存用ディレクトリがなかったら作成
            DirectoryOperator::findOrCreate($this->detailDataDirPath);
            // 詳細ページのスクレイピング結果をCSVに吐き出し
            $csvPath = $this->detailDataDirPath . '/data.csv';
            $this->addDetailDataToCsv($data, $csvPath);

            echo "progress: " . $index . '/' . count($detailHtmlPaths) . "\n";
        }
    }

    /**
     * @param array $detailData
     * @param string $csvFilePath
     */
    private function addDetailDataToCsv($detailData, $csvFilePath): void
    {
        $csvFile = new SplFileObject($csvFilePath, 'a+');
        $csvFile->seek(PHP_INT_MAX);
        if ($csvFile->key() == 0) {
            $csvFile->fputcsv(array_keys($detailData));
        }
        $csvFile->fputcsv(array_values($detailData));
    }

    /**
     * @return array
     */
    public static function scrapingTargets(): array
    {
        return [
            'name' => '.section_h1-header-title', // 名前
            'rent' => '.property_view_detail-info-main .property_view_main-emphasis', // 賃料
            'commonServiceFee' => '.property_view_detail-info-main .property_data-body', // 管理費・共益費
            'securityDeposit' => '.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:first-child', // 敷金
            'gratuityFee' => '.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:last-child', // 礼金
            'guaranteeDeposit' => '.property_view_detail-info-sub .l-property_data li:nth-child(2) .property_data-body', // 保証金
            'repayment' => '.property_view_detail-info-sub .l-property_data li:last-child .property_data-body', // 敷引・償却
            'floorPlan' => '.property_view_detail--floor_type .l-property_data li:first-child .property_data-body', // 間取り
            'occupiedArea' => '.property_view_detail--floor_type .l-property_data li:nth-child(2) .property_data-body', // 専有面積
            'direction' => '.property_view_detail--floor_type .l-property_data li:nth-child(3) .property_data-body', // 向き
            'buildingType' => '.property_view_detail--floor_type .l-property_data li:nth-child(4) .property_data-body', // 建物種別
            'age' => '.property_view_detail--floor_type .l-property_data li:last-child .property_data-body', // 築年数
        ];
    }
}