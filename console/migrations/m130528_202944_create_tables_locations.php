<?php

use yii\db\Schema;

class m130528_202944_create_tables_locations extends \yii\db\Migration
{
	public function safeUp()
	{
$sql = <<<'EOT'
CREATE TABLE {{%locationtype}}
(
  ident text not null primary key, -- Expressive identifier for the location type (e.g. country, state, city)
  type text not null, -- Type of the location type (either boundary,settlement or highway)
  name text not null, -- Name of the location type (I18N aware)
  description text not null -- Description for the location type (I18N aware)
);
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON TABLE {{%locationtype}}
  IS 'The type of a location; mainly according to http://wiki.openstreetmap.org/wiki/Map_Features#Places; additionally highways and postal codes';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%locationtype}}.ident IS 'Expressive identifier for the location type (e.g. country, state, city)';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%locationtype}}.type IS 'Type of the location type (either boundary,settlement or highway)';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%locationtype}}.name IS 'Name of the location type (I18N aware)';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%locationtype}}.description IS 'Description for the location type (I18N aware)';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%locationtype}} (ident, name, description, type) VALUES 
    ('city', 'Großstadt', 'Eine eigenständige Stadt mit normalerweise mehr als 100.000 Einwohnern', 'settlement')
    ,('neighbourhood', 'Ortsteil', 'Ein nicht eigenständiger Teil eines Orts bzw. einer Stadt', 'settlement')
    ,('suburb', 'Stadtteil', 'Ein nicht eigenständiger Teil einer Stadt', 'settlement')
    ,('town', 'Stadt', 'Ein eigenständige Stadt mit normalerweise mehr als 10.000 Einwohnern', 'settlement')
    ,('village', 'Dorf', 'Ein eigenständiges Dorf mit normalerweise weniger als 10.000 Einwohnern', 'settlement')
    ,('postal_code', 'Postleitzahl', 'Eine Postleitzahlbezirk', 'boundary')
    ,('continent', 'Kontinent', 'Einer der sieben Kontinente', 'boundary')
    ,('country', 'Land', 'Ein Land', 'boundary')
    ,('county', 'Landkreis', 'Ein Landkreis', 'boundary')
    ,('region', 'Region', 'Eine Region ', 'boundary')
    ,('state', 'Bundesland', 'Ein Bundesland', 'boundary')
    ,('highway', 'Straße', 'Eine Straße oder ein Platz mit Straßenschild', 'highway')
    ;
EOT;
$this->execute($sql);



$sql = <<<'EOT'
CREATE TABLE {{%location}}
(
  id serial NOT NULL primary key, -- System generated surrogate key
  locationtype_ref text NOT NULL, -- Reference to the locationtype
  short_name text NOT NULL DEFAULT ''::text, -- Short name of  the location
  long_name text NOT NULL DEFAULT ''::text
);
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%location}}.id IS 'System generated surrogate key';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%location}}.locationtype_ref IS 'Reference to the locationtype';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
COMMENT ON COLUMN {{%location}}.short_name IS 'Short name of  the location';
EOT;
$this->execute($sql);
$sql = <<<'EOT'
ALTER TABLE {{%location}} ADD CONSTRAINT {{%location_locationtype_fk}} FOREIGN KEY (locationtype_ref) REFERENCES {{%locationtype}} (ident)
   ON UPDATE RESTRICT ON DELETE RESTRICT;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
CREATE INDEX {{%location_locationtype_fki}} ON {{%location}}(locationtype_ref);
EOT;
$this->execute($sql);

$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, short_name, long_name) VALUES (1, 'country', 'DE', 'Deutschland');
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, short_name, long_name) VALUES 
   (1000, 'state', 'BW', 'Baden-Württemberg')
  ,(1001, 'state', 'BY', 'Bayern')
  ,(1002, 'state', 'BE', 'Berlin')
  ,(1003, 'state', 'BB', 'Brandenburg')
  ,(1004, 'state', 'HB', 'Bremen')
  ,(1005, 'state', 'HH', 'Hamburg')
  ,(1006, 'state', 'HE', 'Hessen')
  ,(1007, 'state', 'NI', 'Niedersachen')
  ,(1008, 'state', 'MV', 'Mecklenburg-Vorpommern')
  ,(1009, 'state', 'NW', 'Nordrhein-Westfalen')
  ,(1010, 'state', 'RP', 'Rheinland-Pfalz')
  ,(1011, 'state', 'SL', 'Saarland')
  ,(1012, 'state', 'SN', 'Sachsen')
  ,(1013, 'state', 'ST', 'Sachsen-Anhalt')
  ,(1014, 'state', 'SH', 'Schleswig-Holstein')
  ,(1015, 'state', 'TH', '(Thüringen')
;        
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, short_name, long_name) VALUES 
    (10000, 'city', 'KA', 'Karlsruhe')
    ;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, long_name) VALUES 
    (100000, 'suburb', 'Grötzingen')
    ,(100001, 'suburb', 'Durlach')
    ,(100002, 'suburb', 'Bergwald')
    ,(100003, 'suburb', 'Wolfartsweier')
    ,(100004, 'suburb', 'Grünwettersbach')
    ,(100005, 'suburb', 'Hohenwettersbach')
    ,(100006, 'suburb', 'Palmbach')
    ,(100007, 'suburb', 'Stupferich')
    ;
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, short_name, long_name) VALUES (110000, 'neighbourhood', '', 'Geigersberg');
EOT;
$this->execute($sql);
$sql = <<<'EOT'
INSERT INTO {{%location}} (id, locationtype_ref, short_name, long_name) VALUES (1000000, 'highway', '', 'Am Knittelberg');
EOT;
$this->execute($sql);
$sql = <<<'EOT'
ALTER SEQUENCE {{%location_id_seq}} RESTART with 1100000;
EOT;
$this->execute($sql);

$sql = <<<'EOT'
CREATE TABLE {{%locationhierachy}}
(
  id serial NOT NULL primary key,
  path ltree NOT NULL
);
EOT;
$this->execute($sql);
$sql = <<<'EOT'
CREATE INDEX {{%locationhierachy_path_gist_idx}} ON {{%locationhierachy}} USING gist(path);
EOT;
$this->execute($sql);
$sql = <<<'EOT'
CREATE INDEX {{%locationhierachy_path_btree_idx}} ON {{%locationhierachy}} USING btree(path)
EOT;
$this->execute($sql);

$sql = <<<'EOT'
INSERT INTO {{%locationhierachy}} (path) VALUES 
    ('1') -- DE
    ,('1.1000') -- States
    ,('1.1001')
    ,('1.1002')
    ,('1.1003')
    ,('1.1004')
    ,('1.1005')
    ,('1.1006')
    ,('1.1007')
    ,('1.1008')
    ,('1.1009')
    ,('1.1010')
    ,('1.1011')
    ,('1.1012')
    ,('1.1013')
    ,('1.1014')
    ,('1.1015')
    ,('1.1000.10000') -- KA
    ,('1.1000.10000.100000') -- Ortsteile
    ,('1.1000.10000.100001') 
    ,('1.1000.10000.100002') 
    ,('1.1000.10000.100003')
    ,('1.1000.10000.100004')
    ,('1.1000.10000.100005')
    ,('1.1000.10000.100006')
    ,('1.1000.10000.100007')
    
;        
EOT;
$this->execute($sql);

$sql = <<<'EOT'
ALTER SEQUENCE {{%locationhierachy_id_seq}} RESTART with 100000;
EOT;
$this->execute($sql);
        }

	public function safeDown()
	{
$sql = <<<'EOT'
drop table {{%locationhierachy}};
EOT;
$this->execute($sql);
$sql = <<<'EOT'
drop table {{%location}};
EOT;
$this->execute($sql);
$sql = <<<'EOT'
drop table {{%locationtype}};
EOT;
$this->execute($sql);

	}
}