<?php

use yii\db\Schema;
use yii\db\Migration;

class m150226_073140_owner_fkey_cascade extends Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
alter table {{%campaign}}
drop constraint tbl_campaign_owner_id_fkey,
add constraint tbl_campaign_owner_id_fkey
   foreign key (owner_id)
   references {{%user}}(id)
   on delete cascade;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
alter table {{%citation}}
drop constraint tbl_citation_owner_id_fkey,
add constraint tbl_citation_owner_id_fkey
   foreign key (owner_id)
   references {{%user}}(id)
   on delete cascade;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
alter table {{%picture}}
drop constraint tbl_picture_owner_id_fkey,
add constraint tbl_picture_owner_id_fkey
   foreign key (owner_id)
   references {{%user}}(id)
   on delete cascade;
EOT;
$this->execute($sql);

    }

    public function safeDown()
    {
    }
}
