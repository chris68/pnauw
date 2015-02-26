<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class UserdataForm extends Model
{
    public $new_username;
    public $new_email;
    public $new_password;
    
    public $delete_user;
    public $verifyCode;

    public $old_password;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['new_username', 'filter', 'filter' => 'trim'],
            ['new_username', 'unique', 'targetAttribute' => 'username', 'targetClass' => '\common\models\User', 'message' => \Yii::t('common','This user name has already been taken.')],
            ['new_username', 'compare', 'operator' => '!=', 'compareValue' => 'Guest access', 'message' => \Yii::t('common','This user name is reserved.')],
            ['new_username', 'string', 'min' => 2, 'max' => 255],

            ['new_email', 'filter', 'filter' => 'trim'],
            ['new_email', 'email'],
            ['new_email', 'unique', 'targetAttribute' => 'email', 'targetClass' => '\common\models\User', 'message' => \Yii::t('common','This email address has already been taken.')],

            ['new_password', 'string', 'min' => 6],

            ['delete_user', 'boolean', ],
            [['delete_user'], 'filter', 'filter' => 'boolval', 'skipOnEmpty' => true],
            ['verifyCode', 'captcha', 
                'when' => function($model) { return $model->delete_user; },
                'whenClient' => "function (attribute, value) { return false;}"
            ],

            ['old_password', 'required'],
            ['old_password', 'validatePassword'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'new_username' => 'Neuer Nutzername',
            'new_email' => 'Neue Emailadresse',
            'new_password' => 'Neues Passwort',
            'old_password' => 'Derzeitiges Passwort',
            'delete_user' => 'Nutzer löschen',
            'verifyCode' => 'Prüfcode',
        ];
    }

     /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->getUser()->validatePassword($this->old_password)) {
                $this->addError('old_password', 'Das derzeitige Passwort ist falsch');
            }
        }
    }

    /**
     * Save the changes.
     *
     */
    public function save()
    {
        $user = $this->getUser();

        if ($this->delete_user) {
            $user->delete();
            Yii::$app->user->logout();
        } else {
            if ($this->new_username !== '') {
                $user->username = $this->new_username;
            }

            if ($this->new_email !== '') {
                $user->email = $this->new_email;
            }

            if ($this->new_password !== '') {
                $user->setPassword($this->new_password);
                $user->generateAuthKey();
            }

            $user->save();
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findIdentity(Yii::$app->user->getId());
        }

        return $this->_user;
    }

}
