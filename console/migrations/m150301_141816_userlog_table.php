<?php

use yii\db\Schema;
use yii\db\Migration;

class m150301_141816_userlog_table extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE TABLE tbl_userlog
(
    id                                                    serial NOT NULL,
    ts                                                    TIMESTAMP NOT NULL,
    event                                                 text NOT NULL,
    log                                                   text NOT NULL,
    owner_id                                              int NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (owner_id) REFERENCES tbl_user (id) ON UPDATE CASCADE ON DELETE CASCADE
) WITH OIDS;
EOT;
$this->execute($sql);

    }

    public function safeDown()
    {
$sql = <<<'EOT'
DROP TABLE tbl_userlog;
EOT;
$this->execute($sql);
    }
}
