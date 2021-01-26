<?php

use yii\db\Migration;

/**
 * Class m210126_184016_citation_history
 */
class m210126_184016_citation_history extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%citation}}', 'history', 'text not null default \'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%citation}}', 'history');
    }
}
