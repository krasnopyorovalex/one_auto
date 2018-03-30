<?php

namespace common\models;

/**
 * This is the model class for table "{{%auto_generations}}".
 *
 * @property int $id
 * @property int $model_id
 * @property string $name
 * @property string $h1
 * @property string $alias
 *
 * @property AutoModels $model
 */
class AutoGenerations extends \yii\db\ActiveRecord
{

    private $type = 'generation';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auto_generations}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'name', 'alias'], 'required'],
            [['model_id'], 'integer'],
            [['name', 'h1'], 'string', 'max' => 512],
            [['alias'], 'string', 'max' => 255],
            [['alias'], 'unique'],
            [['model_id'], 'exist', 'skipOnError' => true, 'targetClass' => AutoModels::className(), 'targetAttribute' => ['model_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'model_id' => 'Model ID',
            'h1' => 'h1',
            'name' => 'Название модификации',
            'alias' => 'Alias'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(AutoModels::className(), ['id' => 'model_id']);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
