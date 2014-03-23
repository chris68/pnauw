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

class EnsureOwnership extends Behavior {

    /**
     * @var mixed The name of the attribute to store the owner_id. Defaults to 'owner_id'
     */
    public $ownerAttribute = 'owner_id';

    /**
     * @var boolean Ensure the correct ownership also for find? Defaults to true
     */
    public $ensureOnFind = true;

	/**
	 * Declares event handlers for the [[owner]]'s events.
	 * @return array events (array keys) and the corresponding event handler methods (array values).
	 */
	public function events()
	{
		return [
			ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
			ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
			ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
			ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
		];
	}

    /**
     * Set the owner id to the current user upon object creation
     * Checks if owner id fits to current user upon object update
     *
     * @param yii\base\Event $event event parameter
     */
    public function beforeSave($event) {
        if ($this->owner->getIsNewRecord()) {
            $this->owner->{$this->ownerAttribute} = \Yii::$app->user->getId();
        } else {
            if ($this->owner->{$this->ownerAttribute} <> \Yii::$app->user->getId())
                throw new HttpException(403, \Yii::t('common','You are not authorized to perform this action'));
            
        }
    }

    /**
     * Checks if owner id fits to current user upon object deletion
     *
     * @param yii\base\Event $event event parameter
     */
    public function beforeDelete($event) {
        if ($this->owner->{$this->ownerAttribute} <> \Yii::$app->user->getId()) {
            throw new HttpException(403, \Yii::t('common','You are not authorized to perform this action'));
		}
    }
    
    /**
     * Checks if owner id fits to current user after the objects has been found
     *
     * @param yii\base\Event $event event parameter
     */
    public function afterFind($event) {
        if ($this->ensureOnFind && $this->owner->{$this->ownerAttribute} <> \Yii::$app->user->getId()) {
            throw new HttpException(403, \Yii::t('common','You are not authorized to perform this action'));
		}
    }
}
?>