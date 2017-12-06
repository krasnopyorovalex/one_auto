<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * SubscribeForm is the model behind the contact form.
 */
class SubscribeForm extends Model
{

    const SUBJECT = 'Форма подписаться';

    public $email;
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['email', 'name'], 'trim'],
            ['email', 'email'],
            [['name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Ваш email',
            'name' => 'Ваше имя'
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('subscribe',['model' => $this])
            ->setTo($email)
            ->setFrom(['info@krasber.ru' => $this->name])
            ->setSubject(self::SUBJECT)
            ->send();
    }
}
