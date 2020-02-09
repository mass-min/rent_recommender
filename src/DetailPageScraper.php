<?php

namespace RentRecommender;

require_once "vendor/autoload.php";

class DetailPageScraper
{
    /**
     * @param string $detailHtmlFileName
     * @return void
     */
    public function execute(string $detailHtmlFileName): void
    {
        $domDetailPage = \phpQuery::newDocumentFile($detailHtmlFileName);

        $data = [];
        $data['name'] = trim($domDetailPage->find('.section_h1-header-title')->text());
        $rentSection = $domDetailPage->find('.property_view_detail-info-main');
        // 賃料
        $data['rent'] = trim(pq($rentSection)->find('.property_view_main-emphasis')->text());
        // 管理費・共益費
        $data['commonServiceFee'] = trim(pq($rentSection)->find('.property_data-body')->text());

        $initialCostSection = $domDetailPage->find('.property_view_detail-info-sub .l-property_data');
        // 敷金
        $data['securityDeposit'] = trim($initialCostSection->find('li:first-child .property_data-body span:first-child')->text());
        // 礼金
        $data['gratuityFee'] = trim($initialCostSection->find('li:first-child .property_data-body span:last-child')->text());
        // 保証金
        $data['guaranteeDeposit'] = trim($initialCostSection->find('li:nth-child(2) .property_data-body')->text());
        // 敷引・償却
        $data['repayment'] = trim($initialCostSection->find('li:last-child .property_data-body')->text());

        var_dump($data);
    }
}

$detailPageScraper = new DetailPageScraper();
$detailPageScraper->execute('tmp/detailHtml/detail_1.html');