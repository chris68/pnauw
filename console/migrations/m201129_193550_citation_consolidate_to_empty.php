<?php

use yii\db\Migration;

/**
 * Class m201129_193550_citation_consolidate_to_empty
 */
class m201129_193550_citation_consolidate_to_empty extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->update('{{%citation}}',['type' => 'empty'],['type' => ['public','protected']]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201129_193550_citation_consolidate_to_empty cannot be reverted.\n";

        return false;
    }

}
