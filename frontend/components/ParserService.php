<?php

namespace frontend\components;

use frontend\widgets\Blocks;
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

        preg_match_all("/{block_[0-9]+}/", $text, $matches);
        if(isset($matches[0]) && count($matches[0])){
            $text = array_map(function ($item){
                 return Blocks::widget([
                    'id' => (int)str_replace(['{','}','block_'],'',$item)
                ]);
            },$matches[0]);
            $text = implode('&nbsp;', $text);
        }
        return $text;
    }
}