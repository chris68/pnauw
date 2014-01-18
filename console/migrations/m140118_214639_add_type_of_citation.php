<?php

use yii\db\Schema;

class m140118_214639_add_type_of_citation extends \yii\db\Migration
{
	public function safeUp()
	{
		$this->addColumn('{{%citation}}', 'type', 'text not null default \'citation\'');
	}

	public function safeDown()
	{
		$this->dropColumn('{{%citation}}', 'type');
	}
}
