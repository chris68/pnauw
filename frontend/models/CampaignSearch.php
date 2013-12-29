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

	public function rules()
	{
		return [
			[['id', 'owner_id'], 'integer'],
			[['name', 'description', 'running_from', 'running_until', 'visibility_id', 'loc_path', 'created_ts', 'modified_ts', 'released_ts', 'deleted_ts'], 'safe'],
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
			'running_from' => 'Running From',
			'running_until' => 'Running Until',
			'visibility_id' => 'Visibility ID',
			'loc_path' => 'Loc Path',
			'created_ts' => 'Created Ts',
			'modified_ts' => 'Modified Ts',
			'released_ts' => 'Released Ts',
			'deleted_ts' => 'Deleted Ts',
		];
	}

	public function search($params)
	{
		$query = Campaign::find();
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
		$this->addCondition($query, 'running_from');
		$this->addCondition($query, 'running_until');
		$this->addCondition($query, 'visibility_id', true);
		$this->addCondition($query, 'loc_path', true);
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
