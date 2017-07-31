<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%portfolio}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $domain
 * @property string $description
 * @property integer $pos
 *
 * @property PortfolioImages[] $portfolioImages
 */
class Portfolio extends \yii\db\ActiveRecord
{
    const GALLERY_SAVE_PATH = '/userfiles/gallery/';

    public $filesGallery;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%portfolio}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'domain'], 'required'],
            [['description'], 'string'],
            [['pos'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['domain'], 'string', 'max' => 128],
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
            'domain' => 'Адрес сайта',
            'description' => 'Описание',
            'pos' => 'Позиция'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolioImages()
    {
        return $this->hasMany(PortfolioImages::className(), ['portfolio_id' => 'id'])->orderBy('pos');
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $fullPath = \Yii::getAlias('@files'. self::GALLERY_SAVE_PATH . $this->id);
            FileHelper::removeDirectory($fullPath);
            return true;
        } else {
            return false;
        }
    }
}
