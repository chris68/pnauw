<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Defines the query and scope functions
 */
class CitationQuery extends ActiveQuery
{
    /**
     * Scope for the owner 
     */
    public function ownerScope()
    {
        $this->andWhere("{{%citation}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
        return $this;
    }

    /**
     * Scope for retrieving the dropdown list
     */
    public function dropdownScope()
    {
        $this->andWhere("{{%citation}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
        return $this;
    }
}
