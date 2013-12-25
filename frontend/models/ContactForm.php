<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
	public $name;
	public $email;
	public $subject;
	public $body;
	public $verifyCode;

	/**
	 * @return array the validation rules.
	 */
	public function rules()
	{
		return [
			// name, email, subject and body are required
			[['name', 'email', 'subject', 'body'], 'required'],
			// email has to be a valid email address
			['email', 'email'],
			// verifyCode needs to be entered correctly
			['verifyCode', 'captcha'],
		];
	}

	/**
	 * @return array customized attribute labels
	 */
	public function attributeLabels()
	{
		return [
			'name' => \Yii::t('base','Name'), 
                        'email' => \Yii::t('base','Email'), 
                        'subject' => \Yii::t('base','Subject'), 
                        'body' => \Yii::t('base', 'Body'),
			'verifyCode' => \Yii::t('base','Verification Code'),
		];
	}

	/**
	 * Sends an email using the information collected by this model.
	 * @return boolean whether the model passes validation
	 */
	public function contact()
	{
		if ($this->validate()) {
			Yii::$app->mail->compose()
				->setTo([$this->email => $this->name])
				->setBcc(Yii::$app->params['contactEmail'])
				->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name . ' robot'])
				->setSubject($this->subject)
				->setTextBody($this->body)
				->send();
			return true;
		} else {
			return false;
		}
	}
}
