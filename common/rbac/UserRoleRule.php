<?php

namespace common\rbac;

use yii\rbac\Rule;
use common\models\User;

/** 
 * Checks if user role matches user passed via params  
 * @link http://www.fabioferreira.pt/rbac-with-yii2-user-quick-tutorial Explanation of the usage pattern
 */
class UserRoleRule extends Rule
{
    public $name = 'UserRole';


	public function execute($user, $item, $params)
	{		 
		// Check the role from table user         
		if (isset(\Yii::$app->user->identity->role))
			$role = \Yii::$app->user->identity->role;
		else
			return false;

		// Here the children hierachie of the roles needs to be replicated in a flat reverse order
		if ($item->name === 'admin') {
			return $role == User::ROLE_ADMIN;
		} elseif ($item->name === 'moderator') {
			return $role == User::ROLE_MODERATOR ||  $role == User::ROLE_ADMIN;
		} elseif ($item->name === 'trusted') {
			return $role == User::ROLE_TRUSTED || $role == User::ROLE_MODERATOR ||  $role == User::ROLE_ADMIN;
		} elseif ($item->name === 'user') {
			return $role == User::ROLE_USER || User::ROLE_ANONYMOUS || $role == User::ROLE_TRUSTED || $role == User::ROLE_MODERATOR ||  $role == User::ROLE_ADMIN;
		} elseif ($item->name === 'anonymous') {
			return $role ==  User::ROLE_ANONYMOUS;
		} else {
			return false;
		}
	}
}
