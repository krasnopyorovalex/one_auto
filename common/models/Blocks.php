<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%blocks}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property string $description
 * @property string $btn_text
 * @property string $color
 */
class Blocks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blocks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'btn_text', 'color'], 'required'],
            [['price', 'description'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['btn_text'], 'string', 'max' => 64],
            [['link'], 'string', 'max' => 128],
            [['color'], 'string', 'max' => 16],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'price' => 'Цена',
            'description' => 'Описание',
            'btn_text' => 'Текст кнопки',
            'color' => 'Цвет',
            'link' => 'Ссылка для названия блока',
        ];
    }
}
