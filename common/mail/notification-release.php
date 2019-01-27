<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
Hallo <?=$user->username?>!

Bei der Webplattform parke-nicht-auf-unseren-wegen.de ist soeben die neue Release <?=Yii::$app->version?> veröffentlicht worden. Die Neuerungen finden Sie in der Releasehistorie (https://parke-nicht-auf-unseren-wegen.de/site/releasehistory).

Eventuell wurden auch die Nutzungsbedingungen (https://parke-nicht-auf-unseren-wegen.de/site/terms) oder Datenschutzbedingungen (https://parke-nicht-auf-unseren-wegen.de/site/privacy) geändert. Am besten lesen Sie sich diese daher noch einmal schnell durch, ob Sie immer noch mit allem einverstanden sind.

Es würde uns freuen, wenn wir Sie bald mal wieder auf unserer Plattform begrüßen dürften.

===================================================================================================

Sie bekommen diese Email, weil Sie bei parke-nicht-auf-unseren-wegen.de unter dem Nutzer <?=$user->username?> mit der Emailadresse <?=$user->email?> registriert sind. Wenn Sie parke-nicht-auf-unseren-wegen.de nicht mehr nutzen wollen, dann löschen Ihren Nutzer bitte in der Nutzerverwaltung.

Bitte antworten Sie nicht auf diese Mail, sondern nutzen Sie stattdessen bitte die Kontaktseite (https://parke-nicht-auf-unseren-wegen.de/site/contact)
