<?php
namespace frontend\controllers;
use frontend\models\ContactForm;
use Yii;

trait ContactTrait {
    /**
     * Displays contact page for contacting the owner of the Flyer model
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $link
     * @return mixed
     */
    private function contact($id,$link)
    {
        $model = new ContactForm();
        $owner = $this->findModel($id)->owner;
        if (empty($owner->email)) {
            Yii::$app->session->setFlash('info',"Das entsprechende Objekt (<a href='$link'>$link</a>) wurde anonym angelegt. Daher ginge die Mail nur an den Betreiber der Webseite");
            $bcc = Yii::$app->params['contactEmail'];
        } else {
            Yii::$app->session->setFlash('info',"Die Mail wird an den Ersteller des Objekts (<a href='$link'>$link</a>) gehen und NICHT an den Betreiber der Webseite");
            $bcc = $owner->email;
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail($bcc)) {
                Yii::$app->session->setFlash('success', 'Die Mail ist raus. Ob jemand antwortet liegt nicht in der Hand des Betreibers der Webseite.');
            } else {
                Yii::$app->session->setFlash('error', 'Es gab einen Fehler beim Mailversand');
            }

            return $this->refresh();
        } else {
            $model->body = 
<<<STRING



==============================
Erläuterungen bitte nicht löschen
==============================

Diese Mail wurde über die Plattform Parke-nicht-auf-unseren-Wegen.de verschickt. Der Verfasser der Mail bekommt die Mail als Hauptadressat, Empfänger in Blindkopie ist der Ersteller des folgenden Objekts:

$link

Wenn der Ersteller des Objekts anonym war, dann geht die Mail an die Betreiber der Webseite.
STRING;
            return $this->render('/site/contact', [
                'model' => $model,
            ]);
        }
    }
}
 