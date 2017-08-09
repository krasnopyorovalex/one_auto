<?php

namespace common\models;

/**
 * This is the model class for table "{{%redirects}}".
 *
 * @property integer $id
 * @property string $old_alias
 * @property string $new_alias
 * @property integer $date
 */
class Redirects extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%redirects}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['old_alias', 'new_alias'], 'required'],
            [['date'], 'integer'],
            [['old_alias', 'new_alias'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'old_alias' => 'Старый url',
            'new_alias' => 'Новый url',
            'date' => 'Дата',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date = time();
            return true;
        }
        return false;
    }
}
