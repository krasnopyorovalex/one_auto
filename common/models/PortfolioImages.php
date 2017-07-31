<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%portfolio_images}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $ext
 * @property integer $pos
 * @property string $alt
 * @property string $title
 * @property integer $portfolio_id
 *
 * @property Portfolio $portfolio
 */
class PortfolioImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%portfolio_images}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ext'], 'required'],
            [['pos', 'portfolio_id'], 'integer'],
            [['name'], 'string', 'max' => 32],
            [['ext'], 'string', 'max' => 4],
            [['alt', 'title'], 'string', 'max' => 512],
            [['portfolio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Portfolio::className(), 'targetAttribute' => ['portfolio_id' => 'id']],
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
            'ext' => 'Ext',
            'pos' => 'Pos',
            'alt' => 'Alt',
            'title' => 'Title',
            'portfolio_id' => 'Portfolio ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPortfolio()
    {
        return $this->hasOne(Portfolio::className(), ['id' => 'portfolio_id']);
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->name.'.'.$this->ext;
    }

    /**
     * @return string
     */
    public function getFullNameThumb()
    {
        return $this->name.'_thumb.'.$this->ext;
    }

    /**
     * @return bool|string
     */
    public function getFullPath()
    {
        return \Yii::getAlias('@frontend/web'.Portfolio::GALLERY_SAVE_PATH.$this->portfolio_id.'/');
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            $file = $this->getFullPath().$this->getFullName();
            $fileThumb = $this->getFullPath().$this->getFullNameThumb();
            if(file_exists($file)){
                unlink($file);
                unlink($fileThumb);
            }
            return true;
        } else {
            return false;
        }
    }
}
