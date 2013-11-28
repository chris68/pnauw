<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Picture;

/**
 * PictureSearch represents the model behind the search form about Picture.
 */
class PictureSearch extends Model
{
	public $id;
	public $owner_id;
	public $name;
	public $description;
	public $taken;
	public $org_loc_lat;
	public $org_loc_lng;
	public $loc_lat;
	public $loc_lng;
	public $loc_path;
	public $loc_formatted_addr;
	public $original_image_id;
	public $small_image_id;
	public $medium_image_id;
	public $thumbnail_image_id;
	public $blurred_small_image_id;
	public $blurred_medium_image_id;
	public $blurred_thumbnail_image_id;
	public $clip_x;
	public $clip_y;
	public $clip_size;
	public $visibility_id;
	public $vehicle_country_code;
	public $vehicle_reg_plate;
	public $citation_affix;
	public $action_id;
	public $incident_id;
	public $citation_id;
	public $campaign_id;
	public $created_ts;
	public $modified_ts;
	public $deleted_ts;

	public function rules()
	{
		return [
			[['id', 'owner_id', 'original_image_id', 'small_image_id', 'medium_image_id', 'thumbnail_image_id', 'blurred_small_image_id', 'blurred_medium_image_id', 'blurred_thumbnail_image_id', 'clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', 'campaign_id'], 'integer'],
			[['name', 'description', 'taken', 'org_loc_lat', 'org_loc_lng', 'loc_lat', 'loc_lng', 'loc_path', 'loc_formatted_addr', 'visibility_id', 'vehicle_country_code', 'vehicle_reg_plate', 'citation_affix', 'created_ts', 'modified_ts', 'deleted_ts'], 'safe'],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'owner_id' => 'Eigner',
			'name' => 'Bildname',
			'description' => 'Beschreibung',
			'taken' => 'Aufgenommen am',
			'org_loc_lat' => 'Org Loc Lat',
			'org_loc_lng' => 'Org Loc Lng',
			'loc_lat' => 'Breite (lat.)',
			'loc_lng' => 'Länge (long.)',
			'loc_path' => 'Ort (Pfad)',
			'loc_formatted_addr' => 'Ortsangabe',
			'original_image_id' => 'Original Image',
			'small_image_id' => 'Small Image',
			'medium_image_id' => 'Medium Image',
			'thumbnail_image_id' => 'Thumbnail Image',
			'blurred_small_image_id' => 'Blurred Small Image',
			'blurred_medium_image_id' => 'Blurred Medium Image',
			'blurred_thumbnail_image_id' => 'Blurred Thumbnail Image',
			'visibility_id' => 'Sichtbarkeit',
			'vehicle_country_code' => 'Kfz-Ländercode',
			'vehicle_reg_plate' => 'Kennzeichen',
			'citation_affix' => 'Anzeigenzusatz',
			'action_id' => 'Maßnahme',
			'incident_id' => 'Vorfall',
			'citation_id' => 'Anzeige',
			'campaign_id' => 'Kampagne',
			'created_ts' => 'Hochgeladen am',
			'modified_ts' => 'Geändert am',
			'deleted_ts' => 'Gelöscht am',
			
			// @Todo: Check whether still needed
			'visibility___name' => 'Sichtbarkeit',
			'incident___name' => 'Vorfall',
			'citation__name' => 'Anzeige',
			'action__name' => 'Maßnahme',
		];
	}

	public function search($params)
	{
		$query = Picture::find();
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
		$this->addCondition($query, 'taken', true);
		$this->addCondition($query, 'org_loc_lat', true);
		$this->addCondition($query, 'org_loc_lng', true);
		$this->addCondition($query, 'loc_lat', true);
		$this->addCondition($query, 'loc_lng', true);
		$this->addCondition($query, 'loc_path', true);
		$this->addCondition($query, 'loc_formatted_addr', true);
		$this->addCondition($query, 'original_image_id');
		$this->addCondition($query, 'small_image_id');
		$this->addCondition($query, 'medium_image_id');
		$this->addCondition($query, 'thumbnail_image_id');
		$this->addCondition($query, 'blurred_small_image_id');
		$this->addCondition($query, 'blurred_medium_image_id');
		$this->addCondition($query, 'blurred_thumbnail_image_id');
		$this->addCondition($query, 'clip_x');
		$this->addCondition($query, 'clip_y');
		$this->addCondition($query, 'clip_size');
		$this->addCondition($query, 'visibility_id', true);
		$this->addCondition($query, 'vehicle_country_code', true);
		$this->addCondition($query, 'vehicle_reg_plate', true);
		$this->addCondition($query, 'citation_affix', true);
		$this->addCondition($query, 'action_id');
		$this->addCondition($query, 'incident_id');
		$this->addCondition($query, 'citation_id');
		$this->addCondition($query, 'campaign_id');
		$this->addCondition($query, 'created_ts', true);
		$this->addCondition($query, 'modified_ts', true);
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