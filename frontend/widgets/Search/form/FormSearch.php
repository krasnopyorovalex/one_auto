<?php

namespace frontend\widgets\Search\form;

use common\models\Products;

class FormSearch extends Products
{
    const TYPE_ARTICUL = 'articul';
    const TYPE_NAME = 'name';
    public $type;
    public $keyword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'keyword'], 'required'],
            ['type', 'in', 'range' => [self::TYPE_ARTICUL, self::TYPE_NAME]]
        ];
    }

    public function search($params)
    {
        $query = ProductsOld::find();

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
        }

        if($this->type == self::TYPE_NAME){
            $query->andFilterWhere([
                'name' => $this->keyword
            ]);
        } else {
            $query->andFilterWhere([
                'articul' => $this->keyword
            ]);
        }

        return $query->asArray()->all();
    }

}