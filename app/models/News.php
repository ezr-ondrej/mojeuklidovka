<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class News extends BaseModel implements SluggableInterface {

    use SluggableTrait;

    protected $sluggable = array(
        'build_from'    => 'title',
        'save_to'       => 'slug',
        'max_length'    => '60',
    );
	protected $table = 'news';
	public $timestamps = true;
	protected $fillable = array('title', 'slug', 'image', 'introduction', 'text', 'website', 'full_address');
	protected $visible = array('title', 'slug', 'image', 'introduction', 'text', 'website', 'full_address');

}