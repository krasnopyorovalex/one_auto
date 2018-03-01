<?php

namespace common\models;

use backend\components\FileBehavior;
use backend\components\MakeListAutoBehavior;
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
 *
 * @mixin MakeListAutoBehavior
 */
class Products extends MainModel
{
    const PATH = '/userfiles/products/';
    const IMAGE_ENTITY = 'image';

    public $file;
    public $bindingAutoList;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            [
                'class' => FileBehavior::class,
                'path' => self::PATH,
                'entity_db' => self::IMAGE_ENTITY
            ],
            [
                'class' => MakeListAutoBehavior::class
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
            [['bindingAutoList'], 'safe']
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
            'bindingAutoList' => 'Выберите из списка модель, поколение',
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

    public function afterFind()
    {
        parent::afterFind();
        if($this->productsAutoVias){
            $this->bindingAutoList = $this->transformListAutoSelectedAfterFind($this->productsAutoVias);
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->unlinkAll('productsAutoVias', true);

        if($this->bindingAutoList){
            $autos = $this->transformListAutoSelectedToSave($this->bindingAutoList);
            array_map(function ($item) {
                $key = key($item);
                return (new ProductsAutoVia([
                    'product_id' => $this->id,
                    'type' => strval($key),
                    'auto_id' => intval($item[$key])
                ]))->save();
            }, $autos);
        }
    }
}
