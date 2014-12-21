<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form about Campaign.
 */
class CampaignSearch extends Model
{
    public $id;
    public $owner_id;
    public $name;
    public $description;
    public $running_from;
    public $running_until;
    public $visibility_id;
    public $loc_path;
    public $created_ts;
    public $modified_ts;
    public $released_ts;
    public $deleted_ts;

    protected $filter_count;
    
    public function rules()
    {
        return [
            [['id', /*'owner_id'*/], 'integer'],
            [['name', 'description', 'running_from', 'running_until', 'visibility_id', /*'loc_path', */ 'created_ts', 'modified_ts', 'released_ts', 'deleted_ts'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'owner_id' => 'Besitzer',
            'name' => 'Name',
            'description' => 'Beschreibung',
            'running_from' => 'Startdatum',
            'running_until' => 'Enddatum',
            'visibility_id' => 'Sichtbarkeit',
            'loc_path' => 'Ort (Pfad)',
            'created_ts' => 'Angelegt am',
            'modified_ts' => 'Verändert am',
            'released_ts' => 'Freigegeben am',
            'deleted_ts' => 'Gelöscht am',
        ];
    }

    public function getFilterStatus() {
        switch ($this->filter_count) {
            case -1:
                return 'Fehler im Filterausdruck';
            case 0:
                return 'Kein Filter gesetzt';
            default:
                return $this->filter_count.' Filter gesetzt';
        }
    }
    
    public function search($params)
    {
        $query = Campaign::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        
        if (!$this->validate()) {
            $this->filter_count = -1;
            $query->andWhere('1=0');
        }
        else {
            $this->filter_count = 0;
            
            $this->addCondition($query, 'id');
            //$this->addCondition($query, 'owner_id');
            $this->addCondition($query, 'name', true);
            $this->addCondition($query, 'description', true);
            $this->addCondition($query, 'running_from');
            $this->addCondition($query, 'running_until');
            $this->addCondition($query, 'visibility_id');
            //$this->addCondition($query, 'loc_path', true);
            $this->addCondition($query, 'created_ts');
            $this->addCondition($query, 'modified_ts');
            $this->addCondition($query, 'released_ts');
            $this->addCondition($query, 'deleted_ts');
        }
        return $dataProvider;
    }

    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        
        $this->filter_count++;
        
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
