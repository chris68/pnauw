<?php

use yii\db\Migration;

class m170120_165246_user_add_geo_accuracy extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'geo_accuracy', 'int');
        
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'geo_accuracy');
    }

}
