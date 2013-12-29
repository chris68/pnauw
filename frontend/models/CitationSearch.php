<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Citation;

/**
 * CitationSearch represents the model behind the search form about Citation.
 */
class CitationSearch extends Model
{
	public $id;
	public $owner_id;
	public $name;
	public $description;
	public $created_ts;
	public $modified_ts;
	public $released_ts;
	public $deleted_ts;

	protected $filter_count;
	
	public function rules()
	{
		return [
			[['id', /*'owner_id'*/], 'integer'],
			[['name', 'description', 'created_ts', 'modified_ts', 'released_ts', 'deleted_ts'], 'safe'],
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
		$query = Citation::find();
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
			$this->addCondition($query, 'owner_id');
			$this->addCondition($query, 'name', true);
			$this->addCondition($query, 'description', true);
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
			$value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
