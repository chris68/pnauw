<?php

use yii\db\Migration;

class m170115_172524_user_add_reg_codes extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'reg_codes', 'text');
        
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'reg_codes');
    }

}
