<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * CampaignQuery defines the query and scope functions
 */
class CampaignQuery extends ActiveQuery
{
    /**
     * Scope for the owner 
     */
    public function ownerScope()
    {
        $this->andWhere("{{%campaign}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
        return $this;
    }

    /**
     * Scope for retrieving the dropdown list
     */
    public function dropdownScope()
    {
        $this->andWhere("({{%campaign}}.owner_id = :owner or {{%campaign}}.visibility_id = 'public')", [':owner' => \Yii::$app->user->id]);
        return $this;
    }
}
