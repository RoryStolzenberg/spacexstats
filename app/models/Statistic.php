<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Library\Miscellaneous\StatisticDescriptionBuilder;
use SpaceXStats\Library\Miscellaneous\StatisticResultBuilder;

class Statistic extends Model {

	protected $table = 'statistics';
	protected $primaryKey = 'statistic_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['result', 'full_title'];
    protected $fillable = [];
    protected $guarded = [];

	// Attribute Accessors
	public function getResultAttribute() {
		$type = camel_case($this->type);

		if (!empty($this->name)) {
			return StatisticResultBuilder::$type($this->name);
		} else {
			return StatisticResultBuilder::$type();
		}
	}

    public function getFullTitleAttribute() {
        if ($this->type === $this->name || is_null($this->name)) {
            return $this->type;
        } else {
            return $this->type . ' - ' . $this->name;
        }
    }

    public function getDescriptionAttribute() {
        if (is_null($this->description)) {
            return null;
        }

        $type = camel_case($this->type);
        $description = $this->attributes['description'];

        $dynamicData = array();
        preg_match_all("/\{\{\s?(.*)\s?\}\}/U", $description, $dynamicData);

        foreach ($dynamicData[0] as $match => $dynamicString) {
            $description = str_replace($dynamicString, StatisticDescriptionBuilder::$type($this->name, $dynamicData[1][$match]), $description);
        }

        return $description;
    }
}
