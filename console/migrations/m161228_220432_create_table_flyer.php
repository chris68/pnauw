<?php

use yii\db\Migration;

class m161228_220432_create_table_flyer extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE TABLE {{%flyer}}
(
  id serial NOT NULL PRIMARY KEY,
  owner_id int NOT NULL references {{%user}}(id) on delete cascade,
  name text not null,
  description text not null,
  flyertext text not null,
  secret text not null unique,
  running_from date,
  running_until date,
  created_ts timestamp not null default current_timestamp, -- use with http://www.yiiframework.com/wiki/10/
  modified_ts timestamp not null default current_timestamp,
  released_ts timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

    }

    public function safeDown()
    {
$sql = <<<'EOT'
drop table {{%flyer}};
EOT;
$this->execute($sql);
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
