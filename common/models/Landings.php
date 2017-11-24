<?php

namespace common\models;

use backend\components\FileBehavior;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%landings}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property string $image
 * @property string $image_alt
 * @property string $image_title
 * @property integer $pos
 * @property integer $is_landing
 * @property integer $created_at
 * @property integer $updated_at
 */
class Landings extends \yii\db\ActiveRecord
{

    const PATH = '/userfiles/landings/';
    const IMAGE_ENTITY = 'image';
    const IS_LANDING = 1;

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
        return '{{%landings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pos', 'created_at', 'updated_at', 'is_landing'], 'integer'],
            [['name', 'image_alt', 'image_title'], 'string', 'max' => 512],
            [['link'], 'string', 'max' => 255],
            [['image'], 'string', 'max' => 64],
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
            'link' => 'Ссылка для многостраничных сайтов',
            'image' => 'Изображение',
            'file' => 'Изображение',
            'image_alt' => 'alt',
            'image_title' => 'title',
            'pos' => 'Позиция',
            'is_landing' => 'Лендинг?',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
