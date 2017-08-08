<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%menu_items}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property integer $pos
 * @property integer $parent_id
 * @property integer $menu_id
 *
 * @property Menu $menu
 * @property MenuItems $parent
 * @property MenuItems[] $menuItems
 */
class MenuItems extends \yii\db\ActiveRecord
{
    const NOT_PARENT = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_items}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['pos', 'parent_id', 'menu_id'], 'integer'],
            [['name', 'link'], 'string', 'max' => 512],
            [['menu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => MenuItems::className(), 'targetAttribute' => ['parent_id' => 'id']],
            ['link', 'default', 'value' => '/#'],
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
            'link' => 'Ссылка',
            'pos' => 'Позиция',
            'parent_id' => 'Родитель',
            'menu_id' => 'Menu ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItems::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItems::className(), ['parent_id' => 'id']);
    }

    /**
     * @return array
     */
    public function drawDDM()
    {
        $pages = ArrayHelper::map(Pages::find()->asArray()->all(), function ($item){
            return $item['alias'] == 'index' ? str_replace('index','/',$item['alias']) : '/'.$item['alias'];
        },'name', function (){
            return 'Страницы';
        });
        $services = ArrayHelper::map(Services::find()->asArray()->all(), function ($item){
            return '/services/'.$item['alias'];
        },'name', function (){
            return 'Услуги';
        });
        return ArrayHelper::merge($pages,$services);
    }
}
