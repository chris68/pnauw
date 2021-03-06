<?php

/* @var $this yii\web\View */

// @chris68
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Parke nicht auf unseren Wegen!</h1>

        <p class="lead">Gehwegparken nervt und ist meist unnötig. Diese Plattform hilft, es zu bekämpfen!</p>
        <p><small><a href="<?= Url::to(['site/about']) ?>">Hintergrundsinfos</a> &ndash; <a href="<?= Url::to(['site/help']) ?>">Hilfe</a></small></p>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-md-4">
                <h2>Autofahrer</h2>

                <p>Sie sind ein Autofahrer und hatten einen Zettel am Auto?</p>
                <p>Dann schauen Sie doch einfach, was man zu Ihrem Parkverhalten sagt!</p>

                <p>
                    <a class="btn btn-default" href="<?= Url::to(['/picture/index', 's[time_range]' => '-1;0', 's[map_gps]' => 'locate-once', 's[map_bind]' => '1'])?>"><b style="color:red">Hier&amp;heute</b>&raquo;</a>
                    <a class="btn btn-default" href="<?= Url::to(['/picture/index', 's[time_range]' => '-180;0', 's[map_bind]' => '1'])?>">Alle aktuellen Vorfälle&raquo;</a>
                </p>
                <p>
                    Sie können hier generell oder noch besser beim konkreten Vorfall <a href="<?=Url::to(['help']).'#comments'?>" target="_blank">Kommentare</a> hinterlassen.
                </p>
                <p>
                    <a href="<?= Url::to(['site/about'],true) ?>#disqus_thread" data-disqus-identifier="/site/about">Kommentar hinterlassen</a>
                    <script type="text/javascript">
                        /* * * CONFIGURATION VARIABLES * * */
                        var disqus_shortname = 'pnauw';
                        var disqus_identifier = '/site/about';
                        var disqus_url = '<?= Url::to(['site/about'],true)?>';
                        /* * * DON'T EDIT BELOW THIS LINE * * */
                        (function () {
                            var s = document.createElement('script'); s.async = true;
                            s.type = 'text/javascript';
                            s.src = '//' + disqus_shortname + '.disqus.com/count.js';
                            (document.getElementsByTagName('HEAD')[0] || document.getElementsByTagName('BODY')[0]).appendChild(s);
                        }());
                    </script>
                </p>
            </div>
            <div class="col-md-4">
                <h2>Fußgänger</h2>

                <p>Sie sind Fußgänger und finden es nicht lustig, wie ihre Gehwege zugeparkt sind?</p> 
                <p>Dann melden Sie die Vorfälle doch einfach!</p>

                <p>
                    <a class="btn btn-default" href="<?= Url::to(['/picture/create'])?>">Vorfall melden&raquo;</a>
                    <a class="btn btn-default" href="<?= Url::to(['/picture/guestcreate'])?>">als Gast (Anonym)&raquo;</a>
                </p>

                <p>
                    Geht ganz schnell mit der Handykamera und mit dem <a href="<?=Url::to(['help']).'#picture-guestcreate'?>" target="_blank">Gastzugang</a>  müssen sich nicht einmal registrieren.
                </p>
            </div>
            <div class="col-md-4">
                <h2>Mitarbeit</h2>

                <p>Sie wollen im größeren Stil Gehwegparker dokumentieren?</p>
                <p>Dann laden Sie einfach ihre ganzen Bilder hoch!</p>

                <p>
                    <a class="btn btn-default" href="<?= Url::to(['picture/upload'])?>">Bilder hochladen&raquo;</a>
                    <a class="btn btn-default" href="<?= Url::to(['picture/guestupload'])?>">als Gast (Anonym)&raquo;</a>
                </p>
                
                <p>
                    Geht auch im <a href="<?=Url::to(['help']).'#picture-guestupload'?>" target="_blank">Gastzugang</a>, aber besser Sie <?= Html::a("registrieren",['/site/signup'])?> sich hierzu.
                    Und bei reger Teilnahme sollten Sie baldigst eine höhere <a href="<?=Url::to(['help']).'#user-level'?>" target="_blank">Berechtigungsstufe</a> beantragen.
                </p>
            </div>
        </div>

    </div>
</div>
