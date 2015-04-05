<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hallo <?=$user->username?>!

Bei der Webplattform parke-nicht-auf-unseren-wegen.de ist soeben die neue Release <?=Yii::$app->version?> veröffentlicht worden. Die Neuerungen finden Sie in der Releasehistorie (<?=Yii::$app->urlManager->createAbsoluteUrl(['site/releasehistory'])?>).

Es würde uns freuen, wenn wir Sie bald mal wieder auf unserer Plattform begrüßen dürften.

===================================================================================================

Sie bekommen diese Email, weil Sie bei parke-nicht-auf-unseren-wegen.de unter dem Nutzer <?=$user->username?> mit der Emailadresse <?=$user->email?> registriert sind. Wenn Sie parke-nicht-auf-unseren-wegen.de nicht mehr nutzen wollen, dann löschen Ihren Nutzer bitte in der Nutzerverwaltung.

Bitte antworten Sie nicht auf diese Mail, sondern nutzen Sie stattdessen bitte die Kontaktseite (<?=Yii::$app->urlManager->createAbsoluteUrl(['site/contact'])?>)
