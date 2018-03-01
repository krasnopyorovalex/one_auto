<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'language' => 'ru',
    'timeZone'=>'Europe/Moscow',
    'on beforeRequest' => function () {
        (new \frontend\components\RedirectorService())->parse();
    },
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'sender' => [
            'class' => 'frontend\services\SendService'
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'frontend-one-auto',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                //for main domain
                '/' => 'site',
                'robots.txt' => 'robots/txt',
                'search' => 'search',
                'send/<action:(order)>' => 'send/<action>',

                'catalog/<alias:[\wd-]+>' => 'product/show',

                'auto-<brand:[\wd-]+>' => 'auto/brand',
                'auto-<brand:[\wd-]+>/<model:[\wd-]+>' => 'auto/model',
                'auto-<brand:[\wd-]+>/<model:[\wd-]+>/<generation:[\wd-]+>' => 'auto/generation',

                '<alias:[\wd-]+>' => 'site/page',

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/auto-<brand:[\wd-]+>/<model:[\wd-]+>/<generation:[\wd-]+>/<page:\d+>',
                    'route' => 'auto-catalog/products-with-auto',
                    'defaults' => ['model' => '', 'generation' => '', 'page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/auto-<brand:[\wd-]+>/<model:[\wd-]+>/<generation:[\wd-]+>/<page:\d+>',
                    'route' => 'auto-catalog/products-with-auto-subcategory',
                    'defaults' => ['model' => '', 'generation' => '', 'page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/<subsubcategory:[\wd-]+>/auto-<brand:[\wd-]+>/<model:[\wd-]+>/<generation:[\wd-]+>/<page:\d+>',
                    'route' => 'auto-catalog/products-with-auto-sub-subcategory',
                    'defaults' => ['model' => '', 'generation' => '', 'page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<page:\d+>',
                    'route' => 'catalog/show',
                    'defaults' => ['page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/<page:\d+>',
                    'route' => 'catalog/show-sub-category',
                    'defaults' => ['page' => 0]
                ],

                [
                    'pattern' => '<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/<subsubcategory:[\wd-]+>/<page:\d+>',
                    'route' => 'catalog/show-sub-sub-category',
                    'defaults' => ['page' => 0]
                ],


                /*//for subdomains
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>' => 'site',
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/robots.txt' => 'robots/txt',

                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/send/<action:(order)>' => 'send/<action>',
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/catalog/<alias:[\wd-]+>' => 'product/show',

                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<alias:[\wd-]+>/page/<page:\d+>' => 'auto-brand/show',
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<alias:[\wd-]+>' => 'auto-brand/show',

                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<catalog:[\wd-]+>/<category:[\wd-]+>/page/<page:\d+>' => 'category/category',
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<catalog:[\wd-]+>/<category:[\wd-]+>' => 'category/category',

                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>/page/<page:\d+>' => 'subcategory/subcategory',
                $params['server_protocol'] . '<subdomain:[\w-]+>.<server:[\wd-]+.[\w-]+>/<catalog:[\wd-]+>/<category:[\wd-]+>/<subcategory:[\wd-]+>' => 'subcategory/subcategory',*/
            ],
        ],
        'view' => [
            'class' => 'yii\web\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'url' => '\yii\helpers\Url',
                        'stringHelper' => '\yii\helpers\StringHelper'
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
            ],
        ],
    ],
    'params' => $params,
];
