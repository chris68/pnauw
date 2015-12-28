<?php

use yii\db\Schema;
use yii\db\Migration;

class m151228_111028_add_incident_satellite extends Migration
{
    public function safeUp()
    {
        // Add the new incidents; if the already exist skip that
        $transaction = $this->db->beginTransaction();
        try {
            $this->insert('{{%incident}}',['id' => 20, 'sortkey' => -1, 'category'=>'', 'name'=>'#-1', 'description'=>'', 'severity'=>0]);
            $transaction->commit();
        } catch (Exception $ex) {
            $transaction->rollBack();
            echo "\n=================================================================================\nThe new incidents already existed\n=================================================================================\n";
        }
        // Update the newly created or already existing incidents
        $this->update('{{%incident}}',['sortkey' => 2200, 'category'=>'Sonstiges', 'name'=>'Satellitenerfassung', 'description'=>'Erfassung über Satellitenaufnahme', 'severity'=>0],['id' => 20]);
    }

    public function safeDown()
    {
        $this->delete('{{%incident}}',['id' => [20,]]);
    }
}
