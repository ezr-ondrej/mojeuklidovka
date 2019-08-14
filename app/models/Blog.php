<?php

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;

class Blog extends BaseModel implements SluggableInterface {

    use SluggableTrait;

    protected $sluggable = array(
        'build_from'    => 'title',
        'save_to'       => 'slug',
        'max_length'    => '60',
    );
	protected $table = 'blog';
	public $timestamps = true;
	protected $fillable = array('title', 'slug', 'image', 'introduction', 'text');
	protected $visible = array('title', 'slug', 'image', 'introduction', 'text');

}

/*
CREATE TABLE IF NOT EXISTS `blog` (
`id` int(10) unsigned NOT NULL,
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `image` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `introduction` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
 */