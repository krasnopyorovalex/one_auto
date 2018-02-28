<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property int $price
 * @property string $image
 * @property string $articul
 * @property string $balance
 * @property string $barcode
 * @property string $maker
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Catalog $category
 * @property ProductsAutoVia[] $productsAutoVias
 * @property AutoModels[] $autoModels
 */
class Products extends MainModel
{
    const PATH = '/userfiles/products/';
    const IMAGE_ENTITY = 'image';

    public $file;
    public $autoModelsValues;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
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
            [['category_id', 'name', 'alias', 'price', 'articul', 'maker'], 'required'],
            [['category_id', 'price', 'created_at', 'updated_at'], 'integer'],
            [['text'], 'string'],
            [['name'], 'string', 'max' => 512],
            [['alias', 'maker'], 'string', 'max' => 255],
            [['articul', 'original_number'], 'string', 'max' => 128],
            [['barcode', 'balance'], 'string', 'max' => 64],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['category_id' => 'id']],
            [['autoModelsValues'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Наименование продукта',
            'text' => 'Текст',
            'alias' => 'Alias',
            'price' => 'Цена',
            'image' => 'Image',
            'file' => 'Изображение',
            'articul' => 'Артикул',
            'original_number' => 'Оригинальный номер',
            'maker' => 'Производитель',
            'balance' => 'Остаток',
            'barcode' => 'Штрих-код',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'autoModelsValues' => 'Привязка товара к авто'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Catalog::class, ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductsAutoVias()
    {
        return $this->hasMany(ProductsAutoVia::class, ['product_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoModels()
    {
        return $this->hasMany(AutoModels::class, ['id' => 'auto_model_id'])->viaTable('{{%products_auto_via}}', ['product_id' => 'id']);
    }

    public function afterFind()
    {
        $this->autoModelsValues = ArrayHelper::getColumn($this['autoModels'],'id');
    }

    public function afterSave($insert, $changedAttributes)
    {
        $this->unlinkAll('productsAutoVias', true);
        if($this->autoModelsValues){
            foreach ($this->autoModelsValues as $autoModel){
                (new ProductsAutoVia([
                    'product_id' => $this->id,
                    'auto_model_id' => $autoModel
                ]))->save();
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
