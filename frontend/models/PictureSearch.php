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

    // @todo: Separate these attributes into a separate search class/form; and then the form name here will became ps instead of s.
    // See https://github.com/chris68/pnauw/issues/22
    public $map_state;
    public $map_gps;
    public $map_bounds;
    public $map_bind=false;
    public $map_limit_points=true;
    public $time_range;
    
    protected $filter_count;
    
    /**
     * {@inheritdoc}
     */
    public function formName()
    {
        return 's';
    }

    public function rules()
    {
        return [
            [
                ['id', 'owner_id', 'original_image_id', 'small_image_id', 'medium_image_id', 'thumbnail_image_id', 'blurred_small_image_id', 'blurred_medium_image_id', 'blurred_thumbnail_image_id', 'clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', 'campaign_id'],
                'safe'
            ],
            [
                ['name', 'description', 'org_loc_lat', 'org_loc_lng', 'loc_lat', 'loc_lng', 'loc_formatted_addr', 'visibility_id', 'vehicle_country_code', 'vehicle_reg_plate', 'citation_affix', ], 
                'safe'
            ],
            [
                ['taken', 'created_ts', 'modified_ts', 'deleted_ts' ],
                'default', 'value' => NULL],
            [
                ['taken', 'created_ts', 'modified_ts', 'deleted_ts' ], 
                'date', 
            ],
            [    ['map_bind', 'map_limit_points', ],
                'boolean',
            ],
            [    ['map_bounds', 'time_range', 'map_state', 'map_gps'],
                'string',
            ],
            [['vehicle_reg_plate'], 'filter', 'filter' => 'mb_strtoupper', 'skipOnEmpty' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            'public' => [
                'id','taken','name','description', 
                'action_id', 'incident_id', 'campaign_id' , 'loc_formatted_addr',
                'map_bind', 'map_bounds', 'map_limit_points', 'time_range', 'map_state', 'map_gps',
                ],
            'moderator' => [
                'id','taken','name','description', 
                'action_id', 'incident_id', 'campaign_id' , 'loc_formatted_addr',
                'map_bind', 'map_bounds', 'map_limit_points', 'time_range', 'map_state', 'map_gps',
                'created_ts', 'modified_ts', 'deleted_ts',  'visibility_id', 
                ],
            'private' => [
                'id','taken','name','description', 
                'action_id', 'incident_id', 'campaign_id' , 'loc_formatted_addr',
                'map_bind', 'map_bounds', 'map_limit_points', 'time_range', 'map_state', 'map_gps',
                'created_ts', 'modified_ts', 'deleted_ts',  'visibility_id', 
                'vehicle_country_code', 'vehicle_reg_plate', 'citation_id', ],
            'admin' => parent::scenarios()[self::SCENARIO_DEFAULT], // admin may do everthing
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
            
            'map_bounds' => 'Kartengrenzen',
            'map_state' => 'Kartenstatus',
            'map_gps' => 'GPS-Mode',
            'map_bind' => 'Suche durch den Kartenbereich begrenzen',
            'map_limit_points' => 'Auch Ermittlung der Übersichtskarte auf den Kartenbereich beschränken',
            'time_range' => 'Zeitraum',
        ];
    }

    /**
     * Input for a standard dropdown list for all valid items of a time_range
     * @return array 
     */
    public static function dropDownListTimeRanges()
    {
        return \yii\helpers\ArrayHelper::map(
            [
                ['value'=>'', 'name' => 'Keine Einschränkung', 'category' => ''], 
                ['value'=>'0;0', 'name' => 'Heute', 'category' => 'Aktuell'], 
                ['value'=>'-1;0', 'name' => 'Gestern & heute', 'category' => 'Aktuell'], 
                ['value'=>'-7;0', 'name' => '1 Woche zurück', 'category' => 'Aktuell'], 
                ['value'=>'-30;0', 'name' => '1 Monat zurück', 'category' => 'Nahe Vergangenheit'], 
                ['value'=>'-60;0', 'name' => '2 Monate zurück', 'category' => 'Nahe Vergangenheit'], 
                ['value'=>'-90;0', 'name' => '3 Monate zurück', 'category' => 'Nahe Vergangenheit'], 
                ['value'=>'-180;0', 'name' => '6 Monate zurück', 'category' => 'Nahe Vergangenheit'], 
                ['value'=>'-365;0', 'name' => '1 Jahr zurück', 'category' => 'Vergangenheit'], 
                ['value'=>'-730;0', 'name' => '2 Jahre zurück', 'category' => 'Vergangenheit'], 
                ['value'=>'-1095;0', 'name' => '3 Jahre zurück', 'category' => 'Vergangenheit'], 
                ['value'=>'2018;2018', 'name' => '2018', 'category' => 'Jahre'],
                ['value'=>'2017;2017', 'name' => '2017', 'category' => 'Jahre'],
                ['value'=>'2016;2016', 'name' => '2016', 'category' => 'Jahre'],
                ['value'=>'2015;2015', 'name' => '2015', 'category' => 'Jahre'],
                ['value'=>'2014;2014', 'name' => '2014', 'category' => 'Jahre'],
            ],
            'value','name','category');
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
    
    public function search($params, $query=NULL)
    {
        if ($query === NULL) {
            $query = Picture::find();
        } 
            
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($params !== NULL) {
            $this->load($params);
        }
        
        if (!$this->validate()) {
            // Ensure we find nothing!
            $query->andWhere('1=0');
            $this->filter_count = -1;
        } 
        else {
            $this->filter_count = 0;
            $this->addCondition2($query, 'id', 'ARRAY');
            $this->addCondition2($query, 'owner_id', 'ARRAY');
            $this->addCondition($query, 'name', true);
            $this->addCondition($query, 'description', true);
            $this->addCondition2($query, 'taken', 'DATE');
            $this->addCondition($query, 'loc_formatted_addr', true);
            $this->addCondition2($query, 'visibility_id','ARRAY');
            $this->addCondition2($query, 'vehicle_country_code','ARRAY');
            $this->addCondition($query, 'vehicle_reg_plate', true); 
            $this->addCondition($query, 'citation_affix', true);
            $this->addCondition2($query, 'action_id', 'ARRAY');
            $this->addCondition2($query, 'incident_id','ARRAY');
            $this->addCondition2($query, 'citation_id', 'ARRAY');
            $this->addCondition2($query, 'campaign_id', 'ARRAY');
            $this->addCondition2($query, 'created_ts', 'DATE');
            $this->addCondition2($query, 'modified_ts', 'DATE');
            $this->addCondition2($query, 'deleted_ts', 'DATE');
            
            $this->addCondition2($query, 'time_range', 'TIMERANGE', ['attr' => 'taken']);
            if ($this->map_bind) {
                $this->addCondition2($query, 'map_bounds', 'BOUNDS', ['attr_lat' => 'loc_lat', 'attr_lng' => 'loc_lng']);
            }
            else {
                // Clear the map bounds to retrigger the map boundary calculation
                $this->map_bounds = '';
            }
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
        $attribute = "{{%picture}}.".$attribute ;
        // '#' means generally: look for empty value
        if (trim($value) === '#') {
                $query->andWhere(['in',$attribute,'']);
        } else {
            if ($partialMatch) {
                $query->andWhere(['SIMILAR TO', $attribute, $value]);
            } else {
                $query->andWhere([$attribute => $value]);
            }
        }
    }

    // @todo: Completely rewrite the routine and define it as behavior! And then roll it out to the other classes!
    protected function addCondition2($query, $attribute, $type, $params = NULL)
    {
        $value = $this->$attribute;
        if (is_array($value) && count($value) == 0 || !is_array($value) && trim($value) === '') {
            return;
        }
        $this->filter_count++;
        $attribute = "{{%picture}}.".$attribute ;
        switch ($type) {
            case 'DATE':
                $query->andWhere(["date($attribute)" => $value]);
                break;
            case 'BOUNDS':
                $corners = explode(',',$value);
                // Format: "lat_lo,lng_lo,lat_hi,lng_hi"
                $query->andWhere(['between', '{{%picture}}.'.$params['attr_lng'], $corners[0], $corners[2]]);
                $query->andWhere(['between', '{{%picture}}.'.$params['attr_lat'], $corners[1], $corners[3]]);
                break;
            case 'TIMERANGE':
                $range = explode(';',$value);
                if (((substr_count($range[0], '-') == 2) || trim($range[0])=='') && ((substr_count($range[1], '-') == 2) || trim($range[1])=='')) {
                    // If either side contains a date in the ISO format or is empty
                    // If empty then take a very low/high date
                    $low = date_format(date_create(empty($range[0])?'1970-01-01':$range[0]),'Y-m-d');
                    $high = date_format(date_create(empty($range[1])?'9999-01-01':$range[1]),'Y-m-d');
                    // absolute date; absolute date
                    $query->andWhere('date({{%picture}}.'.$params['attr'].') >= \''.$low.'\'');
                    $query->andWhere('date({{%picture}}.'.$params['attr'].') <= \''.$high.'\'');
                } 
                else {
                    $low = (int)(trim($range[0])==''?'1970':$range[0]);
                    $high = (int)(trim($range[1])==''?'9999':$range[1]);
                    if ($low > 0 || $high > 0) {
                        // year;year
                        $query->andWhere('extract( isoyear from {{%picture}}.'.$params['attr'].') between '.$low.' and '.$high);
                        // This does not work!
                        //$query->andWhere('between', 'year({{%picture}}.'.$params['attr'].')',$low, $high);
                    } 
                    else {
                        // relative days; relative days
                        $query->andWhere('date({{%picture}}.'.$params['attr'].') - current_date between '.$low.' and '.$high);
                        // This does not work!
                        //$query->andWhere('between', 'date({{%picture}}.'.$params['attr'].') - current_date', $low, $high);
                    }
                }
                break;
            case 'ARRAY':
                if (!is_array($value)) {
                    $value = [$value];
                }
                // '#' means generally: look for NULL value
                if(($key = array_search('#', $value)) !== false) {
                    unset($value[$key]);
                }
                $condition = ['in',$attribute,$value];
                if ($key !== false) {
                    $condition = ['or',$condition,"$attribute is null"];
                }
                $query->andWhere($condition);
                break;
        }
    }
    
}
