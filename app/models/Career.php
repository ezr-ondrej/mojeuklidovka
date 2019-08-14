<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Career extends BaseModel implements SluggableInterface {

    use SluggableTrait;

    protected $sluggable = array(
        'build_from'    => 'title',
        'save_to'       => 'slug',
        'max_length'    => '120',
    );
	protected $table = 'career';
	public $timestamps = true;
	protected $fillable = array('type', 'title', 'slug', 'description', 'address', 'what', 'when', 'repetitiveness', 'salary');
	protected $visible = array('type', 'title', 'slug', 'description', 'address', 'what', 'when', 'repetitiveness', 'salary');

}