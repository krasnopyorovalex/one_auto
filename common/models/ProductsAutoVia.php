<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_auto_via}}".
 *
 * @property int $product_id
 * @property int $auto_brand_id
 *
 * @property AutoBrands $autoBrand
 * @property Products $product
 */
class ProductsAutoVia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products_auto_via}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'auto_brand_id'], 'required'],
            [['product_id', 'auto_brand_id'], 'integer'],
            [['product_id', 'auto_brand_id'], 'unique', 'targetAttribute' => ['product_id', 'auto_brand_id']],
            [['auto_brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoBrands::className(), 'targetAttribute' => ['auto_brand_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'auto_brand_id' => 'Auto Brand ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoBrand()
    {
        return $this->hasOne(AutoBrands::className(), ['id' => 'auto_brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['id' => 'product_id']);
    }
}
