<?php

namespace RentRecommender;

class DetailLinkSearcher
{
    /**
     * @param $fileName
     * @return array
     */
    public function execute($fileName): array
    {
        $domIndexPage = \phpQuery::newDocumentFileHTML($fileName);
        $detailLinkElements = $domIndexPage->find('.property_inner-title');

        $detailLinks = [];
        foreach ($detailLinkElements as $detailLinkElement) {
            $detailLinks[] = pq($detailLinkElement)->find('a')->attr('href');
        }

        return $detailLinks;
    }
}