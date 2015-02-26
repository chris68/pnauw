<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @var boolean the term acceptance. Used to check whether user accepted the termns and isn't saved in database
     */
    public $acceptTerms = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('common','This user name has already been taken.')],
            ['username', 'compare', 'operator' => '!=', 'compareValue' => 'Guest access', 'message' => \Yii::t('common','This user name is reserved.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => \Yii::t('common','This email address has already been taken.')],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],

            ['acceptTerms', 'required', 'requiredValue' => true, 'message' => \Yii::t('common','You need to accept the terms.')],
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

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                return $user;
            }
        }

        return null;
    }
}
