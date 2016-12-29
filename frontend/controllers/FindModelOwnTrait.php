<?php
namespace frontend\controllers;
use Yii;

trait FindModelOwnTrait {

    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * If the model is not owned by the user, a exception will be thrown
     * @param integer $id
     * @return ActiveRecord the loaded model
     * @throws HttpException if the model cannot be found
     */
    protected function findModelOwn($id)
    {
        $model = self::findModel($id);
        if (Yii::$app->user->can('isObjectOwner', array('model' => $model))) {
            return $model;
        } else {
            throw new HttpException(403, \Yii::t('base', 'You are not authorized to perform this action'));
        }
    }
}
 