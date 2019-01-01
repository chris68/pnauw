<?php

use yii\db\Migration;

/**
 * Class m190101_195505_user_with_empty_email_and_username
 * 
 * Multiple accounts can exist with username and email empty (guest account) 
 */
class m190101_195505_user_with_empty_email_and_username extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
$sql = <<<'EOT'
drop index if exists tbl_user_username_key;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop index if exists tbl_user_email_key;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
create unique index tbl_user_username_key on tbl_user (username) where username <> '';
EOT;
$this->execute($sql);

$sql = <<<'EOT'
create unique index tbl_user_email_key on tbl_user (email) where email <> '';
EOT;
$this->execute($sql);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
$sql = <<<'EOT'
drop index if exists tbl_user_username_key;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop index if exists tbl_user_email_key;
EOT;
$this->execute($sql);

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190101_195505_user_with_empty_email_and_username cannot be reverted.\n";

        return false;
    }
    */
}
