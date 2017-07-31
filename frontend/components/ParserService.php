<?php

namespace frontend\components;

use frontend\widgets\Portfolio;
use frontend\widgets\Products;
use frontend\widgets\Services;
use frontend\widgets\Sitemap;

class ParserService
{
    /**
     * @param $text
     * @return mixed
     */
    public function parse($text)
    {
        if (strstr($text, '{services}')) {
            $text = str_replace('<p>{services}</p>', Services::widget(), $text);
        }
        if (strstr($text, '{portfolio}')) {
            $text = str_replace('<p>{portfolio}</p>', Portfolio::widget(), $text);
        }
        if (strstr($text, '{products}')) {
            $text = str_replace('<p>{products}</p>', Products::widget(), $text);
        }
        if (strstr($text, '{sitemap}')) {
            $text = str_replace('<p>{sitemap}</p>', Sitemap::widget(), $text);
        }
        return $text;
    }
}