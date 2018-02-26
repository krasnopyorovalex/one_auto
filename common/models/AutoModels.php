<?php

namespace common\models;
use backend\components\FileBehavior;

/**
 * This is the model class for table "{{%auto_models}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property string $alias
 * @property string $image
 *
 * @property AutoGenerations[] $autoGenerations
 * @property AutoBrands $brand
 */
class AutoModels extends \yii\db\ActiveRecord
{
    const PATH = '/userfiles/auto_models/';
    const IMAGE_ENTITY = 'image';

    public $file;

    public function behaviors()
    {
        return [
            [
                'class' => FileBehavior::class,
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
        return '{{%auto_models}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['brand_id', 'name', 'alias'], 'required'],
            [['brand_id'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['image'], 'string', 'max' => 36],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoBrands::class, 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Brand ID',
            'name' => 'Name',
            'alias' => 'Alias',
            'image' => 'Image',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoGenerations()
    {
        return $this->hasMany(AutoGenerations::class, ['model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(AutoBrands::class, ['id' => 'brand_id']);
    }
}