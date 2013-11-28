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
  description text not null,
  created_ts timestamp not null default current_timestamp,
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);

$this->insert('{{%visibility}}',array('sortkey' => 1, 'id'=>'private','name'=>'Nicht öffentlich','description'=>'Sichtbar nur für mich selbst'));
$this->insert('{{%visibility}}',array('sortkey' => 2, 'id'=>'limited','name'=>'Teilweise öffentlich','description'=>'Sichtbar für mich und meine Freunde'));
$this->insert('{{%visibility}}',array('sortkey' => 3, 'id'=>'public_approval_pending','name'=>'Öffentlich (nach Freigabe)','description'=>'Sichtbar für alle (nach Freigabe)'));
$this->insert('{{%visibility}}',array('sortkey' => 4, 'id'=>'public','name'=>'Öffentlich','description'=>'Sichtbar für alle'));

$sql = <<<'EOT'
CREATE TABLE {{%incident}}
(
  id serial NOT NULL PRIMARY KEY,
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

$this->insert('{{%incident}}',array('sortkey' => 1, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken', 'description'=>'Auto parkt auf dem Gehweg', 'severity'=>1));
$this->insert('{{%incident}}',array('sortkey' => 2, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (behindernd)', 'description'=>'Auto parkt behindernd auf dem Gehweg', 'severity'=>3));
$this->insert('{{%incident}}',array('sortkey' => 3, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (total behindernd)', 'description'=>'Auto parkt total behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('sortkey' => 4, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (> 1h)', 'description'=>'Auto parkt länger als eine Stunde auf dem Gehweg', 'severity'=>2));
$this->insert('{{%incident}}',array('sortkey' => 5, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (behindernd, > 1h)', 'description'=>'Auto parkt länger als eine Stunde behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('sortkey' => 6, 'category'=>'Gehwegparken (> 1h)', 'name'=>'Gehwegparken (total behindernd, > 1h)', 'description'=>'Auto parkt länger als eine Stunde total behindernd auf dem Gehweg', 'severity'=>4));
$this->insert('{{%incident}}',array('sortkey' => 7, 'category'=>'Nachweis Standzeit', 'name'=>'Parken (Nachweis Standzeit)', 'description'=>'Auto parkt bereits zu der Zeit', 'severity'=>-1));
$this->insert('{{%incident}}',array('sortkey' => 8, 'category'=>'Korrektes Parken', 'name'=>'Korrektes Parken auf der Straße', 'description'=>'Auto parkt korrekt auf der Straße', 'severity'=>0));
$this->insert('{{%incident}}',array('sortkey' => 9, 'category'=>'Korrektes Parken', 'name'=>'Korrektes Parken in Parkbucht', 'description'=>'Auto parkt korrekt in einer Parkbucht', 'severity'=>0));

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
  id serial NOT NULL PRIMARY KEY,
  sortkey real not null unique,
  name text not null unique,
  description text not null,
  created_ts timestamp not null default current_timestamp, -- use with http://www.yiiframework.com/wiki/10/
  modified_ts timestamp not null default current_timestamp,
  deleted_ts timestamp
);
EOT;
$this->execute($sql);
$this->insert('{{%action}}',array('sortkey' => 1, 'name'=>'Keine', 'description'=>'Nichts gemacht'));
$this->insert('{{%action}}',array('sortkey' => 2, 'name'=>'Zettel', 'description'=>'Zettel angebracht'));
$this->insert('{{%action}}',array('sortkey' => 3, 'name'=>'Angesprochen', 'description'=>'Fahrer angesprochen'));
$this->insert('{{%action}}',array('sortkey' => 4, 'name'=>'Polizei gerufen', 'description'=>'Die Polizei gerufen'));
$this->insert('{{%action}}',array('sortkey' => 5, 'name'=>'Anzeige', 'description'=>'Anzeige gestellt'));

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
$this->insert('{{%vehicle_country}}',array('sortkey' => 1, 'category'=>'D-A-CH', 'code'=>'D', 'name'=>'Deutschland', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 2, 'category'=>'D-A-CH', 'code'=>'A', 'name'=>'Österreich', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 3, 'category'=>'D-A-CH', 'code'=>'CH', 'name'=>'Schweiz', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 4, 'category'=>'EU', 'code'=>'I', 'name'=>'Italien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 5, 'category'=>'EU', 'code'=>'F', 'name'=>'Frankreich', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 6, 'category'=>'EU', 'code'=>'E', 'name'=>'Spanien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 7, 'category'=>'EU', 'code'=>'B', 'name'=>'Belgien', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 8, 'category'=>'EU', 'code'=>'NL', 'name'=>'Niederlande', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 9, 'category'=>'EU', 'code'=>'DK', 'name'=>'Dänemark', 'description'=>''));
$this->insert('{{%vehicle_country}}',array('sortkey' => 10, 'category'=>'Sonstige Länder', 'code'=>'XX', 'name'=>'Unbekanntes Land', 'description'=>''));

$sql = <<<'EOT'
CREATE TABLE {{%picture}}
(
  id serial NOT NULL PRIMARY KEY,
  owner_id int NOT NULL references {{%user}}(id),
  
  -- Internal name and description (never public)
  name text NOT NULL,
  description text NOT NULL DEFAULT '',
  
  taken timestamp NOT NULL,

  org_loc_lat real,
  org_loc_lng real,
  loc_lat real,
  loc_lng real,
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
  
  vehicle_country_code text references {{%vehicle_country}}(code), 
  vehicle_reg_plate text, -- https://en.wikipedia.org/wiki/Vehicle_registration_plate
  
  citation_affix text NOT NULL DEFAULT '',
  
  action_id int references {{%action}}(id),
  incident_id int references {{%incident}}(id),
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