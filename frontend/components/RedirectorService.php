<?php
namespace frontend\components;

use common\models\Redirects;
use yii\helpers\Url;

/**
 * Class RedirectorService
 * @package frontend\components
 */
class RedirectorService
{
    /**
     * @var null|string
     */
    private $server;
    /**
     * @var mixed|string
     */
    private $uri;

    /**
     * Redirector constructor.
     */
    public function __construct()
    {
        $this->server = \Yii::$app->request->getHostName();
        $this->uri = \Yii::$app->request->url;
    }

    public function parse()
    {
        if(strstr($this->uri, '//') || (substr($this->uri, -1) == '/' && $this->uri != '/')){
            $this->clearSlashes($this->uri);
        }
        if(strstr($this->uri,'/index')){
            $this->do_redirect(Url::base(true));
        }
        $this->check_301();
    }

    private function check_301()
    {
        $model = Redirects::find()->select(['new_alias','old_alias'])->indexBy('old_alias')->column();
        if(isset($model[$this->uri])){
            $this->do_redirect(Url::base(true) . $model[\Yii::$app->request->url]);
        }
    }

    /**
     * @param $uri
     */
    private function clearSlashes($uri)
    {
        if( substr($uri, -1) == '/' ){
            while( substr($uri, -1) == '/' ){
                $uri = substr($uri, 0, -1);
            }
        }
        $uri = preg_replace("/\/+/","/",$uri);
        $this->do_redirect(Url::base(true) . $uri);
    }

    /**
     * @param $url
     * @param int $status
     */
    private function do_redirect($url, $status = 301)
    {
        \Yii::$app->response->redirect($url, $status)->send();
        \Yii::$app->end();
    }
}