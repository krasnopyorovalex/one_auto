<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * WriteMessageForm is the model behind the contact form.
 */
class WriteMessageForm extends Model
{

    const SUBJECT = 'Поступила телеграмма с нашего сайта';

    public $name;
    public $email;
    public $info;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'info'], 'required'],
            ['email', 'email'],
            ['info', 'validateInfo']
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
            'name' => 'Ваше имя',
            'email' => 'Ваш email',
            'info' => 'Дополнительная информация',
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('write-message',['model' => $this])
            ->setTo($email)
            ->setFrom(['info@krasber.ru' => $this->name])
            ->setSubject(self::SUBJECT)
            ->send();
    }
}
