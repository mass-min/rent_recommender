<?php

namespace RentRecommender;

use DOMWrap\Document;

require_once "vendor/autoload.php";

class DetailPageScraper
{
    /**
     * @param string $detailHtmlFilePath
     * @return void
     */
    public function execute(string $detailHtmlFilePath): void
    {
        $doc = $this->initializeDocumentWithHtml($detailHtmlFilePath);
        $data = [];
        $targets = self::scrapingTargets();

        foreach ($targets as $target) {
            $data[$target['property']] = trim($doc->find($target['selector'])->text());
        }
        var_dump($data);
    }

    /**
     * @param string $htmlFilePath
     * @return Document
     */
    public function initializeDocumentWithHtml(string $htmlFilePath): Document
    {
        $html = file_get_contents($htmlFilePath);
        $doc = new Document();
        $doc->html($html);

        return $doc;
    }

    /**
     * @return array
     */
    public static function scrapingTargets(): array
    {
        return [
            ['property' => 'name', 'selector' => '.section_h1-header-title'], // 名前
            ['property' => 'rent', 'selector' => '.property_view_detail-info-main .property_view_main-emphasis'], // 賃料
            ['property' => 'commonServiceFee', 'selector' => '.property_view_detail-info-main .property_data-body'], // 管理費・共益費
            ['property' => 'securityDeposit', 'selector' => '.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:first-child'], // 敷金
            ['property' => 'gratuityFee', 'selector' => '.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:last-child'], // 礼金
            ['property' => 'guaranteeDeposit', 'selector' => '.property_view_detail-info-sub .l-property_data li:nth-child(2) .property_data-body'], // 保証金
            ['property' => 'repayment', 'selector' => '.property_view_detail-info-sub .l-property_data li:last-child .property_data-body'], // 敷引・償却
            ['property' => 'floorPlan', 'selector' => '.property_view_detail--floor_type .l-property_data li:first-child .property_data-body'], // 間取り
            ['property' => 'occupiedArea', 'selector' => '.property_view_detail--floor_type .l-property_data li:nth-child(2) .property_data-body'], // 専有面積
            ['property' => 'direction', 'selector' => '.property_view_detail--floor_type .l-property_data li:nth-child(3) .property_data-body'], // 向き
            ['property' => 'buildingType', 'selector' => '.property_view_detail--floor_type .l-property_data li:nth-child(4) .property_data-body'], // 建物種別
            ['property' => 'age', 'selector' => '.property_view_detail--floor_type .l-property_data li:last-child .property_data-body'], // 築年数
        ];
    }
}

$detailPageScraper = new DetailPageScraper();
$detailPageScraper->execute('tmp/detailHtml/detail_1.html');