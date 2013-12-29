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

	public function rules()
	{
		return [
			[['id', 'owner_id'], 'integer'],
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
			'owner_id' => 'Owner ID',
			'name' => 'Name',
			'description' => 'Description',
			'created_ts' => 'Created Ts',
			'modified_ts' => 'Modified Ts',
			'released_ts' => 'Released Ts',
			'deleted_ts' => 'Deleted Ts',
		];
	}

	public function search($params)
	{
		$query = Citation::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);

		if (!($this->load($params) && $this->validate())) {
			return $dataProvider;
		}

		$this->addCondition($query, 'id');
		$this->addCondition($query, 'owner_id');
		$this->addCondition($query, 'name', true);
		$this->addCondition($query, 'description', true);
		$this->addCondition($query, 'created_ts', true);
		$this->addCondition($query, 'modified_ts', true);
		$this->addCondition($query, 'released_ts', true);
		$this->addCondition($query, 'deleted_ts', true);
		return $dataProvider;
	}

	protected function addCondition($query, $attribute, $partialMatch = false)
	{
		$value = $this->$attribute;
		if (trim($value) === '') {
			return;
		}
		if ($partialMatch) {
			$value = '%' . strtr($value, ['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']) . '%';
			$query->andWhere(['like', $attribute, $value]);
		} else {
			$query->andWhere([$attribute => $value]);
		}
	}
}
