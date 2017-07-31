<?php

namespace frontend\components;

use frontend\widgets\Portfolio;
use frontend\widgets\Services;

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
        return $text;
    }
}