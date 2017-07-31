<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * WriteMessageForm is the model behind the contact form.
 */
class WriteMessageForm extends Model
{

    const SUBJECT = 'Поступила телеграмма с нашего сайта:)';

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
            ['email', 'email']
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */
    public function sendEmail($email)
    {
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject(self::SUBJECT)
            ->setTextBody($this->info)
            ->send();
    }
}
