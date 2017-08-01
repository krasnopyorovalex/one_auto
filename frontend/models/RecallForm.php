<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * RecallForm is the model behind the contact form.
 */
class RecallForm extends Model
{

    const SUBJECT = 'Форма заказа обратного звоночка';

    public $name;
    public $phone;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Ваше имя',
            'phone' => 'Номер телефона'
        ];
    }

    /**
     * @param $email
     * @return bool
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose('recall',['model' => $this])
            ->setTo($email)
            ->setFrom(['info@krasber.ru' => $this->name])
            ->setSubject(self::SUBJECT)
            ->send();
    }
}
