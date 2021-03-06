<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */


use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use yii\helpers\HtmlPurifier;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Meldungen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'citation-crud';
?>
<div class="citation-view">

    <h1><?= $this->title ?></h1>

    <p>
        <?= Html::a('Bearbeiten', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Löschen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Sind Sie sich mit dem Löschen sicher?',
            'data-method' => 'post',
        ]); ?>
        <?= Html::a('Kopieren', ['copy', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => $model->getAttributeLabel('type'),
                'format' => 'raw',
                'value' => $model->encodeType(),
            ],
            'name:ntext',
            [
                'label' => $model->getAttributeLabel('description'),
                'format' => 'raw',
                'value' => HtmlPurifier::process(Markdown::convert($model->description)),
            ],
            'recipient_email',
            'recipient_address:ntext',
            'printout_url:url',
            [
                'label' => $model->getAttributeLabel('history'),
                'format' => 'raw',
                'value' => HtmlPurifier::process(Markdown::convert($model->history)),
            ],
            'created_ts',
            'modified_ts',
            //'released_ts',
        ],
    ]); ?>
    
    <?=Html::a('Vorfälle der Meldung bearbeiten',['picture/manage', 's[citation_id]' => $model->id,'sort' => $model->type == 'citation'?'vehicle_reg_plate':'zip_location'],['target' => '_blank']) ?>
     | 
    <!-- Button trigger modal -->
    <a href="#print" data-toggle="modal" data-target="#print">Meldung drucken (als Druckansicht darstellen)</a>
<!-- Modal -->
    <div class="modal fade" id="print" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="printform" action="<?= Url::toRoute('print') ?>" method="get" target ='_blank'>
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <button type="button" class="close" 
                           data-dismiss="modal">
                               <span aria-hidden="true">&times;</span>
                               <span class="sr-only">Schließen</span>
                        </button>
                        <h3 class="modal-title">
                            Druckoptionen
                        </h3>
                    </div>

                    <!-- Modal Body -->
    
                    <div class="modal-body">
                      <fieldset>
                        <legend>Listenzusammenfassung</legend>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewlist]" id="p_l_show" value="show" checked>
                            <label class="form-check-label" for="p_l_show">
                              Zeigen
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewlist]" id="p_l_none" value="none">
                            <label class="form-check-label" for="p_l_none">
                              Keine
                            </label>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend>Historie</legend>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[history]" id="p_h_show" value="show">
                            <label class="form-check-label" for="p_h_show">
                              Zeigen
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[history]" id="p_h_none" value="none" checked>
                            <label class="form-check-label" for="p_h_none">
                              Keine
                            </label>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend>Übersichtskarte</legend>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_none" value="none">
                            <label class="form-check-label" for="p_o_none">
                              Keine
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_before" value="before" <?=$model->type!='citation'?'checked':''?>>
                            <label class="form-check-label" for="p_o_before">
                              Am Anfang
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_after" value="after" <?=$model->type=='citation'?'checked':''?>>
                            <label class="form-check-label" for="p_o_after">
                              Am Ende
                            </label>
                          </div>
                        </div>
                      </fieldset>
                      <fieldset>
                        <legend>Sichtbarkeit</legend>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[visibility]" id="p_v_unchanged" value="unchanged" checked>
                            <label class="form-check-label" for="p_v_unchanged">
                              Unverschleiert
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[visibility]" id="p_v_blurred" value="blurred">
                            <label class="form-check-label" for="p_v_blurred">
                              Verschleiert
                            </label>
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    
                    <!-- Hidden Parameters -->
                    <?php
                        echo Html::hiddenInput('id',$model->id);
                        echo Html::hiddenInput('s[citation_id]',$model->id); // Needed for the overview map!
                    ?>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal">
                                    Schließen
                        </button>
                        <button type="submit" class="btn btn-primary">
                            Druckansicht erzeugen
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    | 
    <?=Html::a('Anschreiben drucken (als Druckansicht darstellen)',['letter', 'id' => $model->id],['target' => '_blank']) ?>
    | 
    <?=Html::a(
        'Email erzeugen',
        'mailto:'.rawurlencode($model->recipient_email).'?'.
            'subject='.rawurlencode($this->title).
            '&body='.rawurlencode(
                "Sehr geehrte Damen und Herren\n\n".
                "<persönlicher Text>\n\n".
                "Das eigentliche Schreiben findet sich hinter folgenden Link: ".$model->printout_url."\n\n".
                "Geben Sie diesen Link bitte nur an Empfänger weiter, die auch berechtigt sind, den Inhalt zu lesen, da der Link Lesezugriff auf das Dokument erteilt\n\n".
                "Mit freundlichen Grüßen\n\n\n\n")
        ,
        ['target' => '_blank']
    )?>
</div>
