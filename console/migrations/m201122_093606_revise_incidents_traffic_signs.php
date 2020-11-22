<?php

use yii\db\Migration;

/**
 * Class m201122_093606_revise_incidents_traffic_signs
 */
class m201122_093606_revise_incidents_traffic_signs extends Migration
{
    public function safeUp()
    {
        $this->insert('{{%incident}}',['id' => 21, 'sortkey' => 3000, 'category'=>'Sonstiges', 'name'=>'Verkehrszeichen ist unsinnig', 'description'=>'Das Verkehrszeichen ist unsinnig, aber es behindert einen nicht', 'severity'=>1]);
        $this->insert('{{%incident}}',['id' => 22, 'sortkey' => 3100, 'category'=>'Sonstiges', 'name'=>'Verkehrszeichen ist hinderlich', 'description'=>'Das Verkehrszeichen ist hinderlich, denn es schränkt einen Fußgänger/Radfahrer unnötig ein', 'severity'=>2],['id' => 22]);
        $this->insert('{{%incident}}',['id' => 23, 'sortkey' => 4000, 'category'=>'Sonstiges', 'name'=>'Freie Nutzung', 'description'=>'Andere Nutzung im Rahmen der AGB', 'severity'=>1],['id' => 23]);
    }

    public function safeDown()
    {
        $this->delete('{{%incident}}',['id' => [21,22,23]]);
    }
}
