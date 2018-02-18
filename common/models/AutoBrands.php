<?php

namespace common\models;

use backend\components\FileBehavior;

/**
 * This is the model class for table "{{%auto_brands}}".
 *
 * @property int $id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $image
 *
 * @property AutoModels[] $autoModels
 */
class AutoBrands extends \yii\db\ActiveRecord
{
    const PATH = '/userfiles/auto_brands/';
    const IMAGE_ENTITY = 'image';

    public $file;

    public function behaviors()
    {
        return [
            [
                'class' => FileBehavior::className(),
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auto_brands}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'text' => 'Text',
            'alias' => 'Alias',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModels::className(), ['brand_id' => 'id']);
    }
}
