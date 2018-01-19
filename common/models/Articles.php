<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $text
 * @property string $preview
 * @property string $image
 * @property string $image_alt
 * @property string $image_title
 * @property string $alias
 * @property string $date
 * @property integer $created_at
 * @property integer $updated_at
 */
class Articles extends MainModel
{

    const PATH = '/userfiles/articles/';
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
        return '{{%articles}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'title'], 'required'],
            [['text', 'preview'], 'string'],
            [['date'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
            [['name', 'title', 'description', 'image_alt', 'image_title'], 'string', 'max' => 512],
            [['image'], 'string', 'max' => 64],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['name', 'description', 'title', 'alias'], 'trim']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'title' => 'Title',
            'description' => 'Description',
            'text' => 'Текст',
            'preview' => 'Превью',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'image_alt' => 'alt',
            'image_title' => 'title',
            'alias' => 'Alias',
            'date' => 'Дата публикации',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
