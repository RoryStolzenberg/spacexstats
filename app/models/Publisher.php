<?php
namespace SpaceXStats\Models;

use Illuminate\Database\Eloquent\Model;
use SpaceXStats\Validators\ValidatableTrait;

class Publisher extends Model {

    use ValidatableTrait;

    protected $table = 'publishers';
    protected $primaryKey = 'publisher_id';
    public $timestamps = false;

    protected $hidden = [];
    protected $appends = ['favicon'];
    protected $fillable = [];
    protected $guarded = [];

    // Validation
    public $rules = [
        'name'          => ['unique:publishers', 'varchar:tiny', 'required'],
        'description'   => ['varchar:medium', 'required'],
        'url'           => ['unique:publishers', 'varchar:small', 'required']
    ];

    public $messages = array();

    // Relations
    public function objects() {
        return $this->hasMany('SpaceXStats\Models\Object');
    }

    // Methods
    public function saveFavicon() {
        $favicon = file_get_contents('http://www.google.com/s2/favicons?domain=' . $this->url);
        create_if_does_not_exist(public_path('media/publications'));
        file_put_contents(public_path('media/publications/' . $this->name . '.jpg'), $favicon);
    }

    // Attribute accessors
    public function getFaviconAttribute() {
        return '/media/publications/' . $this->name . '.jpg';
    }
}
