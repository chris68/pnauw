<?php

use yii\db\Schema;

class m130528_192749_create_tables_picture_image extends \yii\db\Migration
{
    public function safeUp()
    {
$sql = <<<'EOT'
CREATE TABLE {{%image}}
(
  id serial NOT NULL PRIMARY KEY,
  rawdata bytea
);
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE {{%severity}}
(
  level int NOT NULL PRIMARY KEY,
  name text not null unique,
  description text not null,
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

$this->insert('{{%severity}}',array('level'=>-1,'name'=>'weiß','description'=>'Nicht relevant'));
$this->insert('{{%severity}}',array('level'=>0,'name'=>'grün','description'=>'Alles in Ordnung'));
$this->insert('{{%severity}}',array('level'=>1,'name'=>'gelb','description'=>'Leichter Verstoß'));
$this->insert('{{%severity}}',array('level'=>2,'name'=>'dunkelgelb','description'=>'Mittlerer Verstoß'));
$this->insert('{{%severity}}',array('level'=>3,'name'=>'rot','description'=>'Schwerer Verstoß'));
$this->insert('{{%severity}}',array('level'=>4,'name'=>'dunkelrot','description'=>'Extrem schwerer Verstoß'));

$sql = <<<'EOT'
CREATE TABLE {{%visibility}}
(
  id text NOT NULL PRIMARY KEY,
  sortkey real not null unique,
  name text NOT NULL unique,
  category text not null,
  description text not null,
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

$this->insert('{{%visibility}}',array('sortkey' => 100, 'id'=>'private', 'category'=>'Nicht öffentlich', 'name'=>'Noch nicht öffentlich','description'=>'Derzeit nur sichtbar für mich selbst'));
$this->insert('{{%visibility}}',array('sortkey' => 200, 'id'=>'private_hidden', 'category'=>'Nicht öffentlich', 'name'=>'Veröffentlichung geblockt','description'=>'Sichtbar nur für mich selbst und auch nicht für eine Veröffentlichung vergesehen'));
$this->insert('{{%visibility}}',array('sortkey' => 300, 'id'=>'public_approval_pending', 'category'=>'Veröffentlichen', 'name'=>'Veröffentlichung beantragt','description'=>'Antrag auf Veröffentlichung und Review durch einen Moderator'));
$this->insert('{{%visibility}}',array('sortkey' => 400, 'id'=>'public', 'category'=>'Veröffentlichen', 'name'=>'Öffentlich','description'=>'Öffentlich und sichtbar für alle'));
$this->insert('{{%visibility}}',array('sortkey' => 500, 'id'=>'public_approval_rejected', 'category'=>'Moderiert', 'name'=>'Veröffentlichung abgelehnt','description'=>'Die Veröffentlichung wurde von einem Moderator abgelehnt'));
$this->insert('{{%visibility}}',array('sortkey' => 600, 'id'=>'public_approval_withdrawn', 'category'=>'Moderiert', 'name'=>'Veröffentlichung widerrufen','description'=>'Die Veröffentlichung wurde von einem Moderator widerrufen'));

$sql = <<<'EOT'
CREATE TABLE {{%incident}}
(
  id int NOT NULL PRIMARY KEY,
  sortkey real not null unique,
  name text not null unique,
  category text not null,
  description text not null,
  severity int not null references {{%severity}}(level),
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

$this->insert('{{%incident}}',array('id'=>-1,'sortkey' => 0, 'category'=>'', 'name'=>'(noch nicht gesetzt)', 'description'=>'Bild wurde noch nicht klassifiziert', 'severity'=>0));
$this->insert('{{%incident}}',array('id'=>1, 'sortkey' => 100, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken', 'description'=>'Auto parkt auf dem Gehweg', 'severity'=>1));
$this->insert('{{%incident}}',array('id'=>2, 'sortkey' => 200, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (behindernd)', 'description'=>'Auto parkt behindernd auf dem Gehweg', 'severity'=>3));
$this->insert('{{%incident}}',array('id'=>3, 'sortkey' => 300, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (total behindernd)', 'description'=>'Auto parkt total behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('id'=>4, 'sortkey' => 400, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (auf dem Boardstein)', 'description'=>'Auto parkt ganz wenig auf dem Gehweg bzw. nur auf dem Boardstein', 'severity'=>1));
$this->insert('{{%incident}}',array('id'=>5, 'sortkey' => 500, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (> 1h)', 'description'=>'Auto parkt länger als eine Stunde auf dem Gehweg', 'severity'=>2));
$this->insert('{{%incident}}',array('id'=>6, 'sortkey' => 600, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (behindernd, > 1h)', 'description'=>'Auto parkt länger als eine Stunde behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('id'=>7, 'sortkey' => 700, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (total behindernd, > 1h)', 'description'=>'Auto parkt länger als eine Stunde total behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('id'=>8, 'sortkey' => 800, 'category'=>'Nachweis Standzeit', 'name'=>'Parken (Nachweis Standzeit)', 'description'=>'Auto parkt bereits zu der Zeit', 'severity'=>-1));
$this->insert('{{%incident}}',array('id'=>9, 'sortkey' => 900, 'category'=>'Korrektes Parken', 'name'=>'Korrektes Parken auf der Straße', 'description'=>'Auto parkt korrekt auf der Straße', 'severity'=>0));
$this->insert('{{%incident}}',array('id'=>10, 'sortkey' => 1000, 'category'=>'Korrektes Parken', 'name'=>'Korrektes Parken in Parkbucht', 'description'=>'Auto parkt korrekt in einer Parkbucht', 'severity'=>0));
$this->insert('{{%incident}}',array('id'=>11, 'sortkey' => 1100, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Korrektes Parken auf der Straße/Parkbuchten', 'description'=>'Autos parken korrekt auf der Straße/Parkbuchten', 'severity'=>0));
$this->insert('{{%incident}}',array('id'=>12, 'sortkey' => 1200, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Unnötiges Gehwegparken trotz breiter Straße', 'description'=>'Autos parken auf dem Gehweg, obwohl dies hier nicht notwendig wäre', 'severity'=>2));
$this->insert('{{%incident}}',array('id'=>13, 'sortkey' => 1300, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Unnötiges beidseitiges Gehwegparken', 'description'=>'Autos parken beidseitig, obwohl einseitig der Platz reichen würde', 'severity'=>2));
$this->insert('{{%incident}}',array('id'=>14, 'sortkey' => 1400, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Gehwegparken ohne erforderliche Restbreite', 'description'=>'Autos parken mit weniger als die mindestens erforderlichen 1,20 m Restbreite', 'severity'=>3));
$this->insert('{{%incident}}',array('id'=>15, 'sortkey' => 1500, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Gehwege komplett zugeparkt', 'description'=>'Die Gehwege sind komplett zugeparkt und man muss die Straße nutzen', 'severity'=>4));

$sql = <<<'EOT'
CREATE TABLE {{%campaign}}
(
  id serial NOT NULL PRIMARY KEY,
  owner_id int NOT NULL references {{%user}}(id),
  name text not null,
  description text not null,
  running_from date,
  running_until date,
  visibility_id text not null references {{%visibility}}(id),
  loc_path ltree, -- not used yet
  created_ts timestamp not null default current_timestamp, -- use with http://www.yiiframework.com/wiki/10/
  modified_ts timestamp not null default current_timestamp,
  released_ts timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE {{%action}}
(
  id int NOT NULL PRIMARY KEY,
  sortkey real not null unique,
  name text not null unique,
  description text not null,
  created_ts timestamp not null default current_timestamp, -- use with http://www.yiiframework.com/wiki/10/
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);
$this->insert('{{%action}}',array('id'=>-1, 'sortkey' => 0, 'name'=>'(noch nicht gesetzt)', 'description'=>''));
$this->insert('{{%action}}',array('id'=>1, 'sortkey' => 100, 'name'=>'Nichts gemacht', 'description'=>'Nichts gemacht'));
$this->insert('{{%action}}',array('id'=>2, 'sortkey' => 200, 'name'=>'Zettel angehängt', 'description'=>'Zettel angebracht'));
$this->insert('{{%action}}',array('id'=>3, 'sortkey' => 300, 'name'=>'Fahrer angesprochen', 'description'=>'Fahrer angesprochen'));
$this->insert('{{%action}}',array('id'=>4, 'sortkey' => 400, 'name'=>'Polizei gerufen', 'description'=>'Die Polizei gerufen'));
$this->insert('{{%action}}',array('id'=>5, 'sortkey' => 500, 'name'=>'Anzeige gestellt', 'description'=>'Anzeige gestellt'));

$sql = <<<'EOT'
CREATE TABLE {{%citation}}
(
  id serial NOT NULL PRIMARY KEY,
  owner_id int NOT NULL references {{%user}}(id),
  name text not null,
  description text not null,
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  released_ts timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

// http://en.wikipedia.org/wiki/List_of_international_vehicle_registration_codes
$sql = <<<'EOT'
CREATE TABLE {{%vehicle_country}}
(
  code text NOT NULL PRIMARY KEY,
  sortkey real not null unique,
  category text not null,
  name text not null unique,
  description text not null,
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);
$this->insert('{{%vehicle_country}}',array('sortkey' => 0, 'category'=>'', 'code'=>'?', 'name'=>'(noch nicht gesetzt)', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 100, 'category'=>'D-A-CH', 'code'=>'D', 'name'=>'Deutschland', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 200, 'category'=>'D-A-CH', 'code'=>'A', 'name'=>'Österreich', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 300, 'category'=>'D-A-CH', 'code'=>'CH', 'name'=>'Schweiz', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 400, 'category'=>'EU', 'code'=>'I', 'name'=>'Italien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 500, 'category'=>'EU', 'code'=>'F', 'name'=>'Frankreich', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 600, 'category'=>'EU', 'code'=>'E', 'name'=>'Spanien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 700, 'category'=>'EU', 'code'=>'B', 'name'=>'Belgien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 800, 'category'=>'EU', 'code'=>'NL', 'name'=>'Niederlande', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 900, 'category'=>'EU', 'code'=>'DK', 'name'=>'Dänemark', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 1000, 'category'=>'Sonstige Länder', 'code'=>'XX', 'name'=>'Unbekanntes Land', 'description'=>''));

$sql = <<<'EOT'
CREATE TABLE {{%picture}}
(
  id serial NOT NULL PRIMARY KEY,
  owner_id int NOT NULL references {{%user}}(id),
  
  -- Name and description
  name text NOT NULL DEFAULT '',
  description text NOT NULL DEFAULT '',
  
  taken timestamp NOT NULL,

  org_loc_lat real NOT NULL,
  org_loc_lng real NOT NULL,
  loc_lat real NOT NULL,
  loc_lng real NOT NULL,
  loc_path ltree, -- not used yet
  loc_formatted_addr text, -- the formatted address from google
  
  original_image_id int references {{%image}}(id),
  small_image_id int references {{%image}}(id), -- 180 x 240
  medium_image_id int references {{%image}}(id), -- 375 x 500
  thumbnail_image_id int references {{%image}}(id), -- 75 x 100
  blurred_small_image_id int references {{%image}}(id), -- 180 x 240, blurred
  blurred_medium_image_id int references {{%image}}(id), -- 375 x 500, blurred
  blurred_thumbnail_image_id int references {{%image}}(id), -- 75 x 100, blurred

  clip_x int not null,
  clip_y int not null,
  clip_size int not null,
  
  visibility_id text not null references {{%visibility}}(id),
  
  vehicle_country_code text not null references {{%vehicle_country}}(code), 
  vehicle_reg_plate text not null default '', -- https://en.wikipedia.org/wiki/Vehicle_registration_plate
  
  citation_affix text NOT NULL DEFAULT '',
  
  action_id int not null references {{%action}}(id),
  incident_id int not null references {{%incident}}(id),
  
  citation_id int references {{%citation}}(id) on delete set null,
  campaign_id int references {{%campaign}}(id) on delete set null,
  
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

    }

    public function safeDown()
    {
$sql = <<<'EOT'
drop table {{%picture}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%vehicle_country}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%citation}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%action}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%campaign}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%incident}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%severity}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%visibility}};
EOT;
$this->execute($sql);

$sql = <<<'EOT'
drop table {{%image}};
EOT;
$this->execute($sql);

    }
}