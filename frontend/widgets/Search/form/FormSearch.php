<?php

namespace frontend\widgets\Search\form;

use common\models\Products;

class FormSearch extends Products
{
    const TYPES = ['articul','name'];
    public $type;
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'keyword'], 'required'],
            ['type', 'in', 'range' => self::TYPES]
        ];
    }

    public function search($params)
    {

    }

}