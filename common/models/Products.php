<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $price
 * @property integer $pos
 * @property string $btn_text
 * @property integer $form_type
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'btn_text'], 'required'],
            [['description'], 'string'],
            [['pos', 'form_type'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['price'], 'string', 'max' => 255],
            [['btn_text'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название продукта',
            'description' => 'Описание',
            'price' => 'Цена',
            'pos' => 'Позиция',
            'btn_text' => 'Текст кнопки',
            'form_type' => 'Тип формы',
        ];
    }
}
