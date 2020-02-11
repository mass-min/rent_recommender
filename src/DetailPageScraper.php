<?php

namespace RentRecommender;

use RentRecommender\Utility\DocumentInitializer;

require_once "vendor/autoload.php";

class DetailPageScraper
{
    /**
     * @param string $detailHtmlFilePath
     * @return void
     */
    public function execute(string $detailHtmlFilePath): void
    {
        $doc = DocumentInitializer::createDocumentWithHtml($detailHtmlFilePath);
        $data = [];
        $targets = self::scrapingTargets();

        foreach ($targets as $property => $selector) {
            var_dump($doc->find($selector));
            $data[$property] = trim($doc->find($selector)->text());
        }
        var_dump($data);
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

$detailPageScraper = new DetailPageScraper();
$detailPageScraper->execute('tmp/detailHtml/detail_1.html');