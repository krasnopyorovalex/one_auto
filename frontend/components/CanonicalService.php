<?php

namespace frontend\components;

class CanonicalService
{

    private $aliasesIsCanonicalDefault = [
        'articles',
        'news',
        'specials',
        'guestbook',
        'reviews',
    ];

    /**
     * @param $model
     * @param $controller
     */
    public function checkCanonical($model, $controller)
    {
        $page = explode('/',\Yii::$app->request->getUrl());
        if(isset($page[3]) && is_numeric($page[3])){
            $model['title'] = $model['title'] . ' - Страница ' . $page[3];
            $model['description'] = ($model['description'] ? $model['description'] . ' - Страница ' . $page[3] : '');
            $controller->is_canonical = true;
        }
        if(in_array($model['alias'], $this->aliasesIsCanonicalDefault)){
            $controller->is_canonical = true;
        }
    }

}