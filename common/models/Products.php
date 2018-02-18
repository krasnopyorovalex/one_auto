<?php

namespace common\models;
use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $subcategory_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property int $price
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property SubCategory $subcategory
 * @property ProductsAutoVia[] $productsAutoVias
 * @property ProductsOptionsVia[] $productsOptionsVias
 * @property ProductsOptions[] $options
 */
class Products extends MainModel
{
    const PATH = '/userfiles/products/';
    const IMAGE_ENTITY = 'image';

    public $file;
    public $options;
    public $autoBrandsValues;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::className(),
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ]
        ]);
    }


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
            [['subcategory_id', 'name', 'alias'], 'required'],
            [['subcategory_id', 'price', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => SubCategory::className(), 'targetAttribute' => ['subcategory_id' => 'id']],
            [['options', 'autoBrandsValues'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subcategory_id' => 'Subcategory ID',
            'name' => 'Name',
            'text' => 'Text',
            'alias' => 'Alias',
            'price' => 'Цена',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(SubCategory::className(), ['id' => 'subcategory_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsAutoVias()
    {
        return $this->hasMany(ProductsAutoVia::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoBrands()
    {
        return $this->hasMany(AutoBrands::className(), ['id' => 'auto_brand_id'])->viaTable('{{%products_auto_via}}', ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsOptionsVias()
    {
        return $this->hasMany(ProductsOptionsVia::className(), ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(ProductsOptions::className(), ['id' => 'option_id'])->viaTable('{{%products_options_via}}', ['product_id' => 'id']);
    }

    public function afterFind()
    {
        $this->autoBrandsValues = ArrayHelper::getColumn($this['autoBrands'],'id');
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->options){
            $this->unlinkAll('options', true);
            foreach ($this->options as $key => $value){
                (new ProductsOptionsVia([
                    'product_id' => $this->id,
                    'option_id' => $key,
                    'value' => $value
                ]))->save();
            }
        }
        $this->unlinkAll('productsAutoVias', true);
        if($this->autoBrandsValues){
            foreach ($this->autoBrandsValues as $autoBrand){
                (new ProductsAutoVia([
                    'product_id' => $this->id,
                    'auto_brand_id' => $autoBrand
                ]))->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
