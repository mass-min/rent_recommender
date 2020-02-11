<?php

namespace RentRecommender\Utility;

use DOMWrap\Document;

class DocumentInitializer
{
    /**
     * @param string $htmlFilePath
     * @return Document
     */
    public static function createDocumentWithHtml(string $htmlFilePath)
    {
        $html = file_get_contents($htmlFilePath);
        $doc = new Document();
        $doc->html($html);

        return $doc;
    }
}