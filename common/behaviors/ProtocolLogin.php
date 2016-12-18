<?php

namespace common\behaviors;

use Yii;
use yii\base\Behavior;
use yii\base\Event;
use yii\web\User;
use common\models\Userlog;

class ProtocolLogin extends Behavior {

    /**
     * @inheritDoc
     */
    public function events()
    {
        return [
            User::EVENT_AFTER_LOGIN => 'afterLogin',
        ];
    }

    /**
     * Protocol the login
     *
     * @param yii\base\Event $event event parameter
     */
    public function afterLogin($event) {
        Userlog::log(
            'login',
            'Login from <'.Yii::$app->getRequest()->getUserHost().'> ['.Yii::$app->getRequest()->getUserIP().'] via '.($event->cookieBased?'cookie':'user/password')
        );
    }
}
?>
