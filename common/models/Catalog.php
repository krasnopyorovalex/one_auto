<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * This is the model class for table "{{%catalog}}".
 *
 * @property int $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $alias
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Category[] $categories
 */
class Catalog extends MainModel
{

    const PATH = '/userfiles/catalog/';
    const IMAGE_ENTITY = 'image';

    public $file;

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
        return '{{%catalog}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title', 'description', 'alias'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'title', 'description'], 'string', 'max' => 512],
            [['image'], 'string', 'max' => 36],
            [['alias'], 'string', 'max' => 255],
            ['alias', 'unique', 'message' =>  'Такой alias уже есть в системе'],
            ['alias', 'match', 'pattern' => '/[a-zA-Z0-9-]+/', 'message' => 'Кириллица в поле alias запрещена'],
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
            'title' => 'Title',
            'description' => 'Description',
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
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['catalog_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($this->isNewRecord && !$this->alias){
                $this->alias = Inflector::slug($this->name);
            }
            return true;
        }
        return false;
    }
}
