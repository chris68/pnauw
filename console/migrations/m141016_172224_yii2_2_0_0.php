<?php

use yii\db\Schema;
use yii\db\Migration;

class m141016_172224_yii2_2_0_0 extends Migration
{
    public function safeUp()
    {
		// Add the to missing columns (for migration); if they already exist then just skip that
		$transaction = $this->db->beginTransaction();
		try {
			$this->addColumn('{{%user}}','created_at', Schema::TYPE_INTEGER . ' NOT NULL');
			$this->addColumn('{{%user}}','updated_at', Schema::TYPE_INTEGER . ' NOT NULL');
			$transaction->commit();
		} catch (Exception $ex) {
			$transaction->rollBack();
			echo "\n=================================================================================\nThe columns `created_at` and `updated_at` already existed\n=================================================================================\n";
		}
            
		// With Yii2 2.0.0 the column is no longer varchar(32)
		$this->alterColumn('{{%user}}','password_hash', Schema::TYPE_STRING);

    }

    public function safeDown()
    {
		
    }
}
