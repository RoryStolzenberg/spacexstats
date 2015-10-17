<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use ColorThief\ColorThief;
use \Mexitek\PHPColors\Color;
use SpaceXStats\Validators\ValidatableTrait;

class DataView extends Model {

    use ValidatableTrait;
    
    protected $table = 'dataviews';
    protected $primaryKey = 'dataview_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['data'];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = array(
        'name' => ['varchar:small'],
        'query' => ['varchar:medium'],
        'summary' => ['varchar:medium']
    );

    public $messages = array();

    // Functions
    public function setColors() {
        AWS::createClient('s3')->getObject(array(
            'Bucket'    => Credential::AWSS3BucketLargeThumbs,
            'Key'       => $this->bannerImage->filename,
            'SaveAs'    => public_path() . '/media/temp/' . $this->bannerImage->filename
        ));

        // Fetch an RGB array of the dominant color
        $rgb = ColorThief::getColor(public_path() . '/media/temp/' . $this->bannerImage->filename);
        // Unlink the file, it is no longer needed.
        unlink(public_path() . '/media/temp/' . $this->bannerImage->filename);
        // Convert RGB array to hex
        $hex = '#' . dechex($rgb[0]) . dechex($rgb[1]) . dechex($rgb[2]);

        // Set properties
        $this->attributes['dark_color'] = $hex;
        $this->attributes['light_color'] = '#' . (new Color($hex))->lighten();
    }

    // Relations
    public function bannerImage() {
        return $this->belongsTo('SpaceXStats\Models\Object', 'banner_image');
    }

    public function getDataAttribute() {
    }

    public function getColumnTitlesAttribute() {
        return json_decode($this->attributes['column_titles']);
    }

    public function setColumnTitlesAttribute($value) {
        $this->attributes['column_titles'] = json_encode($value);
    }
}