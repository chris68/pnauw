<?php
namespace common\models;

use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;

/**
 * Class User
 * @package common\models
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $role
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 */
class User extends ActiveRecord implements IdentityInterface
{
	/**
	 * @var string the raw password. Used to collect password input and isn't saved in database
	 */
	public $password;

	/**
	 * @var boolean the term acceptance. Used to check whether user accepted the termns and isn't saved in database
	 */
	public $acceptTerms = false;

	const STATUS_DELETED = 0;
	const STATUS_BLOCKED = 5;
	const STATUS_ACTIVE = 10;

	// @Todo: Change the role to a string
	const ROLE_USER = 10;
	const ROLE_TRUSTED = 20;
	const ROLE_MODERATOR = 30;
	const ROLE_ADMIN = 99;

	public function behaviors() 
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				],
				// use real timestamps instead of the unix time saved as int
				'timestamp' => new \yii\db\Expression ('NOW()'),
			],
		];
	}

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 * @return IdentityInterface|null the identity object that matches the given ID.
	 */
	public static function findIdentity($id)
	{
		return static::find($id);
	}

	/**
	 * Finds user by username
	 *
	 * @param string $username
	 * @return null|User
	 */
	public static function findByUsername($username)
	{
		return static::find(['username' => $username, 'status' => static::STATUS_ACTIVE]);
	}

	/**
	 * @return int|string current user ID
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string current user auth key
	 */
	public function getAuthKey()
	{
		return $this->auth_key;
	}

	/**
	 * @param string $authKey
	 * @return boolean if auth key is valid for current user
	 */
	public function validateAuthKey($authKey)
	{
		return $this->getAuthKey() === $authKey;
	}

	/**
	 * @param string $password password to validate
	 * @return bool if password provided is valid for current user
	 */
	public function validatePassword($password)
	{
		return Security::validatePassword($password, $this->password_hash);
	}

	public function rules()
	{
		return [
			['username', 'filter', 'filter' => 'trim'],
			['username', 'required'],
			['username', 'string', 'min' => 2, 'max' => 255],
			['username', 'unique', 'message' => \Yii::t('common','This email address has already been taken.'), 'on' => 'signup'],

			['email', 'filter', 'filter' => 'trim'],
			['email', 'required'],
			['email', 'email'],
			['email', 'unique', 'message' => \Yii::t('common','This email address has already been taken.'), 'on' => 'signup'],
			['email', 'exist', 'message' => \Yii::t('common','There is no user with such email.'), 'on' => 'requestPasswordResetToken'],

			['acceptTerms', 'required', 'message' => \Yii::t('common','You need to accept the terms.'), 'on' => 'signup'],
			
			['password', 'required'],
			['password', 'string', 'min' => 6],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'username' => \Yii::t('common','Username'),
			'email' => \Yii::t('common','Email'),
			'password' => \Yii::t('common','Password'),
			'acceptTerms' => \Yii::t('common','Terms accepted'),
		];
	}

	public function scenarios()
	{
		return [
			'signup' => ['username', 'email', 'password', 'acceptTerms'],
			'resetPassword' => ['password'],
			'requestPasswordResetToken' => ['email'],
		];
	}

	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			if (($this->isNewRecord || $this->getScenario() === 'resetPassword') && !empty($this->password)) {
				$this->password_hash = Security::generatePasswordHash($this->password);
			}
			if ($this->isNewRecord) {
				$this->auth_key = Security::generateRandomKey();
			}
			return true;
		}
		return false;
	}
}
