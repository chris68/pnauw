<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */
/* @var $withPublish boolean */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\web\View;
use yii\bootstrap\Collapse;
use yii\bootstrap\ActiveForm;
use frontend\controllers\PictureController;

$this->title = 'Bilder bearbeiten';
$this->params['breadcrumbs'][] = ['label' => 'Bilder bearbeiten', 'url' => ['manage']];
$this->params['help'] = 'picture-manage';
?>
<div class="picture-manage">

    <?=
        Collapse::widget([
            'items' => [
                [
                    'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Suchen und Filtern <span class="badge">'.$searchModel->getFilterStatus().'</span>' ,
                    'encode' => false,
                    'content' => $this->render('_search', ['model' => $searchModel]),
                ],
            ],
            'options' => 
            [
                'style' => 'margin-bottom: 10px'
            ],
       ]);
    ?>
    
    <?= $this->render('_quicksearchbar', ['model' => $searchModel]) ?>
    
    <?= $this->render('_overviewmap', ['private' => 1]) ?>
    
          
    <div style="margin-top: 10px;">
    <?php
        {
            // Generate the massupdate link by changing the route and throwing out sort/pagination

            $params = Yii::$app->getRequest()->getQueryParams();

            unset($params[$dataProvider->getPagination()->pageParam]);
            unset($params[$dataProvider->getSort()->sortParam]);
            $params[$dataProvider->getSort()->sortParam] = 'id';

            $params[0] = '/picture/massupdate';
            echo Html::a('Bilder detailliert bearbeiten', Url::toRoute($params), ['target' => '_blank']);
            echo ' | ';
            $params[0] = '/picture/publish';
            echo Html::a('Bilder veröffentlichen', Url::toRoute($params), ['target' => '_blank']);
            echo ' | ';
        }
    ?>
    <!-- Button trigger modal -->
    <a href="#print" data-toggle="modal" data-target="#print">Drucken</a>
<!-- Modal -->
    <div class="modal fade" id="print" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="printform" action="<?= Url::toRoute('/picture/printmultiple') ?>" method="get" target ='_blank'>
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
                        <legend>Übersichtskarte</legend>
                        <div class="form-group">
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_none" value="none">
                            <label class="form-check-label" for="p_v_none">
                              Keine
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_before" value="before" checked>
                            <label class="form-check-label" for="p_v_before">
                              Am Anfang
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="radio" name="p[overviewmap]" id="p_o_after" value="after">
                            <label class="form-check-label" for="p_v_after">
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
                        foreach((Yii::$app->getRequest()->get('s')??[]) as $key => $value) {
                            echo Html::hiddenInput('s['.$key.']' , $value);
                        }
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
    <?php 
        /* @var $form yii\bootstrap\ActiveForm */
        $form = ActiveForm::begin(); 
    ?>

    <?= $form->errorSummary([$defaultvalues],['class' => "alert alert-danger"]) ?>
    <?=
        Collapse::widget([
            'items' => [
                [
                    'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Vorgabewerte',
                    'encode' => false,
                    'content' =>
                        $this->render('_formtabbed', [
                            'model' => $defaultvalues,
                            'outerform' => $form,
                        ]),
                ],
            ],
            'options' =>
            [
                'style' => 'margin-bottom: 10px'
            ],
       ]);
    ?>

    <div class="form-group">
        <button type="button" class="btn btn-default" onclick="$('.defval-selector').prop('checked', true);">Übernahme setzen</button>
        <button type="button" class="btn btn-default" onclick="$('.defval-selector').prop('checked', false);">Zurücksetzen</button>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{pager}\n{summary}\n{items}\n{pager}",
        'id' => 'picture-list',
        'itemView' => function ($model, $key, $index, $widget) use ($form, $withPublish) {
                        
            if ($withPublish) {
                $model->visibility_id = Yii::$app->user->can('trusted')?'public':'public_approval_pending';
            }

            return
            '<hr>'
            .
            '<div class="row form-group">
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="form-inline">
                        <div class="form-group">'
            .
                        $form->field($model, "[$model->id]selected")->checkbox(['class'=>'defval-selector'])->label('Vorgabewerte übernehmen').'   '
            .
                        $form->field($model, "[$model->id]deleted")->checkbox()->label('Vorfall löschen')
            .
                        '</div>
                    </div>'
            .
                    frontend\widgets\ImageRenderer::widget(
                        [
                            'image' => $model->smallImage,
                            'size' => 'small',
                            'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:5px'],
                        ]
                    )
            .
                    Html::a('Bearbeiten', ['picture/update','id'=>$model->id], ['target' => '_blank'])
            .
                    '<br>'
            .
                    $model->taken
            .
                    '<br>'
            .
                    Html::encode($model->loc_formatted_addr)
            .
                    '<br>'
            .
                    frontend\widgets\VehicleIncidentHistory::widget(
                        [
                            'picture' => $model,
                        ]
                    )
            .

            '    </div>
                <div class="col-sm-4 col-md-4 col-lg-4">'
            .
                    $form->field($model, "[$model->id]name")->textInput()
            .
                    $form->field($model, "[$model->id]description")->textarea(['rows' => 3])
            .
                    $form->field($model, "[$model->id]incident_id")->dropDownList(frontend\models\Incident::dropDownList(), ['tabindex'=> $index*10+1])
            .
                    $form->field($model, "[$model->id]action_id")->dropDownList(frontend\models\Action::dropDownList())
            .
            '    </div>
                <div class="col-sm-4 col-md-4 col-lg-4">'
            .
                    (\Yii::$app->user->can('trusted')?$form->field($model, "[$model->id]campaign_id")->dropDownList(frontend\models\Campaign::dropDownList()):'')
            .
                    $form->field($model, "[$model->id]citation_id")->dropDownList(frontend\models\Citation::dropDownList())
            .
                    $form->field($model, "[$model->id]citation_affix")->textarea(['rows' => 3, ])
            .
                    $form->field($model, "[$model->id]visibility_id")->dropDownList(frontend\models\Visibility::dropDownList())
            .
            '    </div>
            </div>
            '
            .
            '<hr>'
            ;
        },
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Aktualisieren', ['class' => 'btn btn-primary', 'tabindex'=> 10000]) ?>
        <?= Html::resetButton('Abbrechen', ['class' => 'btn btn-default', ]) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>


