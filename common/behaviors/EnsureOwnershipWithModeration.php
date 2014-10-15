<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\db\ActiveRecord;
use yii\web\HttpException;

class EnsureOwnershipWithModeration extends EnsureOwnership {

    /**
     * Set the owner id to the current user upon object creation
     * Checks if owner id fits to current user upon object update
	 * or the user is a moderator (who may change objects from other users)
     *
     * @param yii\base\Event $event event parameter
     */
    public function beforeSave($event) {
        if ($this->owner->getIsNewRecord()) {
            $this->owner->{$this->ownerAttribute} = \Yii::$app->user->getId();
        } else {
            if (!\Yii::$app->user->can('moderator') && $this->owner->{$this->ownerAttribute} <> \Yii::$app->user->getId())
                throw new HttpException(403, \Yii::t('common','You are not authorized to perform this action'));
            
        }
    }

}
?>