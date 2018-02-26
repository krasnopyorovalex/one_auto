<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%products_auto_via}}".
 *
 * @property int $product_id
 * @property int $auto_model_id
 *
 * @property AutoModels $autoModel
 * @property ProductsOld $product
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
            [['product_id', 'auto_model_id'], 'required'],
            [['product_id', 'auto_model_id'], 'integer'],
            [['product_id', 'auto_model_id'], 'unique', 'targetAttribute' => ['product_id', 'auto_model_id']],
            [['auto_model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModels::className(), 'targetAttribute' => ['auto_model_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => ProductsOld::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'auto_model_id' => 'Auto Model ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModel()
    {
        return $this->hasOne(AutoModels::className(), ['id' => 'auto_model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(ProductsOld::className(), ['id' => 'product_id']);
    }
}
