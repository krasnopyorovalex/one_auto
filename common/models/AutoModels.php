<?php

namespace common\models;

/**
 * This is the model class for table "{{%auto_models}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property string $name
 * @property string $alias
 *
 * @property AutoGenerations[] $autoGenerations
 * @property AutoBrands $brand
 */
class AutoModels extends \yii\db\ActiveRecord
{
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
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoBrands::className(), 'targetAttribute' => ['brand_id' => 'id']],
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
            'alias' => 'Alias'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoGenerations()
    {
        return $this->hasMany(AutoGenerations::className(), ['model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(AutoBrands::className(), ['id' => 'brand_id']);
    }
}
