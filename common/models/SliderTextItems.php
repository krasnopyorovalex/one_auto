<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%slider_text_items}}".
 *
 * @property integer $id
 * @property string $text
 * @property integer $slider_text_id
 * @property integer $pos
 *
 * @property SliderText $sliderText
 */
class SliderTextItems extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%slider_text_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'string'],
            [['slider_text_id', 'pos'], 'integer'],
            [['slider_text_id'], 'exist', 'skipOnError' => true, 'targetClass' => SliderText::className(), 'targetAttribute' => ['slider_text_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Текст',
            'slider_text_id' => 'Slider Text ID',
            'pos' => 'Pos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSliderText()
    {
        return $this->hasOne(SliderText::className(), ['id' => 'slider_text_id']);
    }
}
