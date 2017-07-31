<?php

namespace common\models;

use backend\components\FileBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%guestbook}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $text
 * @property string $city
 * @property string $image
 * @property string $image_title
 * @property string $image_alt
 * @property integer $pos
 * @property integer $created_at
 * @property integer $updated_at
 */
class Guestbook extends MainModel
{

    const PATH = '/userfiles/guestbook/';
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
        return '{{%guestbook}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['text'], 'string'],
            [['pos', 'created_at', 'updated_at'], 'integer'],
            [['name', 'city'], 'string', 'max' => 255],
            [['image', 'image_title', 'image_alt'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'text' => 'Текст отзыва',
            'city' => 'Город',
            'image' => 'Изображение',
            'image_title' => 'title',
            'image_alt' => 'alt',
            'pos' => 'Позиция',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file' => 'Выбрать логотип',
        ];
    }
}
