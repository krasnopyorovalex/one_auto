<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 */
class Catalog extends MainModel
{

    const PATH = '/userfiles/catalog/';
    const IMAGE_ENTITY = 'image';

    public $template = 'catalog.twig';
    public $file;

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
        return '{{%catalog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'alias'], 'required'],
            [['text'], 'string'],
            [['parent_id', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 255],
            ['alias', 'unique', 'message' =>  'Такой alias уже есть в системе'],
            ['alias', 'match', 'pattern' => '/[a-zA-Z0-9-]+/', 'message' => 'Кириллица в поле alias запрещена'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Catalog::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'text' => 'Text',
            'alias' => 'Alias',
            'image' => 'Image',
            'file' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent(): ActiveQuery
    {
        return $this->hasOne(Catalog::class, ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatalogs(): ActiveQuery
    {
        return $this->hasMany(Catalog::class, ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts(): ActiveQuery
    {
        return $this->hasMany(Products::class, ['category_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getTree(): array
    {
        $query = self::find();
        if(!$this->isNewRecord){
            $query->where(['<>','id',$this->id]);
        }
        return ArrayHelper::map($query->asArray()->all(), 'id','name');
    }
}
