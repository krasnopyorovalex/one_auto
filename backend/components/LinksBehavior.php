<?php

namespace backend\components;

use yii\base\Behavior;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class LinksBehavior
 * @package backend\components
 */
class LinksBehavior extends Behavior
{

    const POSTFIX = ' * ';
    const SEPARATOR = '/';

    /**
     * @var array show modules in drop down list
     */
    private $modules = [
        'pages' => 'Страницы',
        'catalog' => 'Каталог'
    ];

    private $links = [];

    public function createLinks()
    {
        foreach ($this->modules as $key => $value)
        {
            /**
             * @var $model Model
             */
            $model = \Yii::$app->getModule($key)->getModel();
            $this->eachModuleItems($model::find()->select(['id', 'name','alias'])->all(), $key, $value);
        }
        return ArrayHelper::map($this->links, 'link', 'name', 'module');
    }

    private function eachModuleItems(array $items, $key, $value)
    {
        array_map(function ($item) use ($value, $key) {
            $link = preg_replace("#\/+#", "/", self::SEPARATOR . str_replace('index','/',$item['alias']));
            return $key == 'catalog'
                ? $this->eachCatalog($item, $value)
                : array_push($this->links, [
                    'link' => $link,
                    'name' => self::POSTFIX . $item['name'],
                    'module' => $value
                ]);
        }, $items);
    }

    private function eachCatalog($item, $value, $link = '')
    {
        $link = $link . self::SEPARATOR . $item['alias'];
        $repeatsPostfix = count(explode('/', $link)) - 1;
        array_push($this->links, [
            'link' => $link,
            'name' => str_repeat(self::POSTFIX, $repeatsPostfix) . $item['name'],
            'module' => $value
        ]);

        if( method_exists($item,'getCategories') && ($categories = $item->getCategories()->all()) ){
            array_map(function ($category) use ($value, $link) {
                return $this->eachCatalog($category, $value, $link);
            }, $categories);
        }

        if( method_exists($item,'getSubCategories') && ($subCategories = $item->getSubCategories()->asArray()->all()) ){
            array_map(function ($subCategory) use ($value, $link) {
                return $this->eachCatalog($subCategory, $value, $link);
            }, $subCategories);
        }
    }

}