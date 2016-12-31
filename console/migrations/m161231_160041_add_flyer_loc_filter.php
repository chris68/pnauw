<?php

use yii\db\Migration;

class m161231_160041_add_flyer_loc_filter extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%flyer}}', 'loc_filter', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%flyer}}', 'loc_filter');
    }
}
