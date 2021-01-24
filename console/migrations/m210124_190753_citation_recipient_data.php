<?php

use yii\db\Migration;

/**
 * Class m210124_190753_citation_recipient_data
 */
class m210124_190753_citation_recipient_data extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%citation}}', 'recipient_email', 'text not null default \'\'');
        $this->addColumn('{{%citation}}', 'recipient_address', 'text not null default \'\'');
        $this->addColumn('{{%citation}}', 'printout_url', 'text not null default \'\'');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%citation}}', 'recipient_email');
        $this->dropColumn('{{%citation}}', 'recipient_address', 'text not null default \'\'');
        $this->dropColumn('{{%citation}}', 'printout_url', 'text not null default \'\'');
    }
}
