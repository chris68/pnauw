<?php

use yii\db\Schema;

class m140118_210052_revise_incidents_and_actions extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->insert('{{%incident}}',['id' => 16, 'sortkey' => 410, 'category'=>'Gehwegparken', 'name'=>'Gehwegparken (Überkragung)', 'description'=>'Auto kragt auf den Gehweg hinaus (z.B. vor Garage)', 'severity'=>1]);
        $this->insert('{{%action}}',['id' => 6, 'sortkey' => 250, 'name'=>'An Behörde gemeldet', 'description'=>'Ans Ordnungsamt oä. gemeldet']);
        $this->insert('{{%action}}',['id' => 7, 'sortkey' => 350, 'name'=>'Fahrer überzeugt', 'description'=>'Fahrer überzeugt, dass er nicht mehr auf dem Gehwegparkt']);
        $this->update('{{%action}}', ['name' => 'Fahrer angesprochen'], ['id' => 3]);
        $this->update('{{%action}}', ['name' => 'Zettel angehängt'], ['id' => 2]);
        $this->update('{{%action}}', ['name' => 'Anzeige gestellt'], ['id' => 5]);
        $this->update('{{%action}}', ['name' => 'Nichts gemacht'], ['id' => 1]);
    }

    public function safeDown()
    {
        $this->delete('{{%incident}}',['id' => [16]]);
        $this->delete('{{%action}}',['id' => [6,7]]);
    }
}
