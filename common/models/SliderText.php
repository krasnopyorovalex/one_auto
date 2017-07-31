<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%slider_text}}".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Pages[] $pages
 * @property SliderTextItems[] $sliderTextItems
 */
class SliderText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPages()
    {
        return $this->hasMany(Pages::className(), ['slider_text_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderTextItems()
    {
        return $this->hasMany(SliderTextItems::className(), ['slider_text_id' => 'id']);
    }
}
