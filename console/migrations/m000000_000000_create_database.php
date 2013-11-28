<?php

use yii\db\Schema;

class m000000_000000_create_database extends \yii\db\Migration
{
	public function safeUp()
	{
$sql = <<<'EOT'
CREATE DATABASE pnauw
  WITH ENCODING='UTF8'
       TEMPLATE=template0 -- otherwise we sometimes get problems with encoding!
       OWNER=mailwitch
       CONNECTION LIMIT=-1;
       
EOT;
// $this->execute($sql);
echo "You need to execute the following sql manually:\n\n".$sql."\n\n";

$sql = <<<'EOT'
CREATE EXTENSION ltree; -- Extension for creating hierachies
EOT;
$this->execute($sql);
	}

	public function safeDown()
	{
$sql = <<<'EOT'
DROP DATABASE gwvgw;
EOT;
// $this->execute($sql);
echo "You need to execute the following sql manually:\n\n".$sql."\n\n";

	}

}