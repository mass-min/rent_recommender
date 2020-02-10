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
        $detailHtml = file_get_contents($detailHtmlFilePath);
        $doc = new Document();
        $doc->html($detailHtml);

        $data = [];
        $data['name'] = trim($doc->find('.section_h1-header-title')->text());
        // 賃料
        $data['rent'] = trim($doc->find('.property_view_detail-info-main .property_view_main-emphasis')->text());
        // 管理費・共益費
        $data['commonServiceFee'] = trim($doc->find('.property_view_detail-info-main .property_data-body')->text());

        // 敷金
        $data['securityDeposit'] = trim($doc->find('.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:first-child')->text());
        // 礼金
        $data['gratuityFee'] = trim($doc->find('.property_view_detail-info-sub .l-property_data li:first-child .property_data-body span:last-child')->text());
        // 保証金
        $data['guaranteeDeposit'] = trim($doc->find('.property_view_detail-info-sub .l-property_data li:nth-child(2) .property_data-body')->text());
        // 敷引・償却
        $data['repayment'] = trim($doc->find('.property_view_detail-info-sub .l-property_data li:last-child .property_data-body')->text());

        // 間取り
        $data['floorPlan'] = trim($doc->find('.property_view_detail--floor_type .l-property_data li:first-child .property_data-body')->text());
        // 専有面積
        $data['occupiedArea'] = trim($doc->find('.property_view_detail--floor_type .l-property_data li:nth-child(2) .property_data-body')->text());
        // 向き
        $data['direction'] = trim($doc->find('.property_view_detail--floor_type .l-property_data li:nth-child(3) .property_data-body')->text());
        // 建物種別
        $data['buildingType'] = trim($doc->find('.property_view_detail--floor_type .l-property_data li:nth-child(4) .property_data-body')->text());
        // 築年数
        $data['age'] = trim($doc->find('.property_view_detail--floor_type .l-property_data li:last-child .property_data-body')->text());

        var_dump($data);
    }
}

$detailPageScraper = new DetailPageScraper();
$detailPageScraper->execute('tmp/detailHtml/detail_1.html');