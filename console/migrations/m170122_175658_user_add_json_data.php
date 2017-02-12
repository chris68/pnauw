<?php

use yii\db\Migration;
use yii\db\Expression;

class m170122_175658_user_add_json_data extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'appdata', 'json'); // @todo: migrate to jsonb as soon as supported by Ubuntu in our prod version
        $this->update('{{%user}}', ['appdata' => new Expression("json_build_object('geo_accuracy',coalesce(geo_accuracy,15),'reg_codes',coalesce(reg_codes,'KA,PF,GER,SÜW,RP,LD,HD,RA,OG,S')")]);
        $this->dropColumn('{{%user}}', 'reg_codes');
        $this->dropColumn('{{%user}}', 'geo_accuracy');
    }

    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'appdata');
        $this->addColumn('{{%user}}', 'reg_codes', 'text');
        $this->addColumn('{{%user}}', 'geo_accuracy', 'int');
    }
}
