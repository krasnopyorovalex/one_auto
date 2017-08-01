<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * OrderForm is the model behind the contact form.
 */
class OrderForm extends Model
{

    const SUBJECT = 'Форма заказа услуги';

    public $service;
    public $phone;
    public $email;
    public $fio;
    public $info;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['service', 'phone', 'email', 'fio'], 'required'],
            [['service', 'phone', 'email', 'fio'], 'trim'],
            ['email', 'email'],
            [['info'], 'string'],
            ['info', 'validateInfo'],
        ];
    }

    public function validateInfo()
    {
        if (strstr($this->info, 'http')) {
            $this->addError('info', 'Нельзя вводить ссылки');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'service' => 'Услуга',
            'phone' => 'Номер телефона',
            'email' => 'Ваш email',
            'fio' => 'Ваше имя',
            'info' => 'Дополнительная информация',
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('order',['model' => $this])
            ->setTo($email)
            ->setFrom(['info@krasber.ru' => $this->fio])
            ->setSubject(self::SUBJECT)
            ->send();
    }
}