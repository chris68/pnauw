<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * FlyerQuery defines the query and scope functions
 */
class FlyerQuery extends ActiveQuery
{
    /**
     * Scope for the owner 
     */
    public function ownerScope()
    {
        $this->andWhere("{{%flyer}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
        return $this;
    }
}
