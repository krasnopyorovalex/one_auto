<?php

namespace common\models;

use backend\components\FileBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%sof_work}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $image_title
 * @property string $image_alt
 * @property integer $pos
 * @property integer $created_at
 * @property integer $updated_at
 */
class SofWork extends MainModel
{
    const PATH = '/userfiles/sof_work/';
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
        return '{{%sof_work}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['description'], 'string'],
            [['pos', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'name' => 'Название',
            'description' => 'Этап работы',
            'image' => 'Изображение',
            'image_title' => 'title',
            'image_alt' => 'alt',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file' => 'Выбрать иконку',
            'pos' => 'Позиция',
        ];
    }
}
