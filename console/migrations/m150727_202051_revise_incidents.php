<?php

use yii\db\Schema;
use yii\db\Migration;

class m150727_202051_revise_incidents extends Migration
{
    public function safeUp()
    {
        // Add the new incidents; if the already exist skip that
        $transaction = $this->db->beginTransaction();
        try {
            $this->insert('{{%incident}}',['id' => 17, 'sortkey' => -1, 'category'=>'', 'name'=>'#-1', 'description'=>'', 'severity'=>0]);
            $this->insert('{{%incident}}',['id' => 18, 'sortkey' => -2, 'category'=>'', 'name'=>'#-2', 'description'=>'', 'severity'=>0]);
            $this->insert('{{%incident}}',['id' => 19, 'sortkey' => -3, 'category'=>'', 'name'=>'#-3', 'description'=>'', 'severity'=>0]);
            $transaction->commit();
        } catch (Exception $ex) {
            $transaction->rollBack();
            echo "\n=================================================================================\nThe new incidents already existed\n=================================================================================\n";
        }
        // Update the newly created or already existing incidents
        $this->update('{{%incident}}',['sortkey' => 1700, 'category'=>'Situation (bei Bild mit mehreren Autos)', 'name'=>'Sinnvolles Gehwegparken', 'description'=>'Hier ist Gehwegparken sinnvoll und sollte angemessen legalisiert werden', 'severity'=>0],['id' => 17]);
        $this->update('{{%incident}}',['sortkey' => 2000, 'category'=>'Sonstiges', 'name'=>'Andere Verstöße', 'description'=>'Irgendwelche anderen Verstöße', 'severity'=>1],['id' => 18]);
        $this->update('{{%incident}}',['sortkey' => 2100, 'category'=>'Sonstiges', 'name'=>'Situationsbild', 'description'=>'Bild einer Situation', 'severity'=>0],['id' => 19]);
    }

    public function safeDown()
    {
        $this->delete('{{%incident}}',['id' => [17,18,19]]);
    }
}
