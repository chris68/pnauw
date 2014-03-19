<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * Defines the query and scope functions
 */
class PictureQuery extends ActiveQuery
{
	/**
	 * Scope for the owner
	 */
	public function ownerScope()
	{
		$this->andWhere("{{%picture}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
		return $this;
	}

	/**
	 * Scope for the public
	 */
	public function publicScope()
	{
		$this->andWhere(["{{%picture}}.visibility_id" => ['public_approval_pending','public']]);
		return $this;
	}
}
