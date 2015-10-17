<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yii\db\ActiveQuery;
use yii\mail\MessageInterface;
use common\models\User;
use common\models\Userlog;

/**
 * Commands to manage the mails to the users
 */
class MailController extends Controller
{
    /**
     * Sends out a release notification mail to the users
     */
    public function actionSendReleaseNotification()
    {
        $success = true;
        foreach (User::find()->where(['<>','role',User::ROLE_ANONYMOUS])->each(10) as $user) {
            $message = Yii::$app->mailer->compose(['text' => 'notification-release'], ['user' => $user])
                ->setTo([$user->email => $user->username])
                ->setFrom([Yii::$app->params['noreplyEmail'] => Yii::$app->name . ' (robot)'])
                ->setSubject("Bei der Plattform 'Parke nicht auf unseren Wegen' (parke-nicht-auf-unseren-wegen.de) wurde soeben die Release ".Yii::$app->version." veröffentlicht" );
            $success = $this->send($user,$message) && $success;
        }

        $this->stdout("All mails send successfully\n", Console::FG_GREEN);

        return $success;
    }

    /**
     * Sends out the mail and protocolls the success/failure in the user's log
     * @param User $user The user to mail will be send to
     * @param MessageInterface $message The message
     * @return bool True if sucessfull
     */
    private function send(User $user, MessageInterface $message)
    {
        if ($success = $message->send()) {
            Userlog::log('mail', $message->getSubject(), $user->id);
        } else {
            $this->stdout("Mail failed for user ".$user->username." (".$user->email.")\n", Console::BOLD, Console::FG_RED);
        }

        return $success;
    }
}