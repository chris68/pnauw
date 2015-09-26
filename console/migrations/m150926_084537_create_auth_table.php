<?php

use yii\db\Schema;
use yii\db\Migration;

class m150926_084537_create_auth_table extends Migration
{
    public function safeup()
    {
$sql = <<<'EOT'
CREATE TABLE {{%auth}} (
    id serial NOT NULL PRIMARY KEY,
    user_id int NOT NULL references {{%user}}(id) on delete cascade on update cascade,
    source text NOT NULL,
    source_id text NOT NULL,
    source_name text NOT NULL
);
EOT;
$this->execute($sql);
    }

    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
    }
    
}
