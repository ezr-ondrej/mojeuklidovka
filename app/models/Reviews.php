<?php

class Reviews extends BaseModel {

	protected $table = 'reviews';
	public $timestamps = true;
	protected $fillable = array('name', 'stars', 'comment', 'improvement', 'public');
	protected $visible = array('name', 'stars', 'comment', 'improvement', 'public');

}

/*
CREATE TABLE IF NOT EXISTS `reviews` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
    `stars` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
    `comment` text COLLATE utf8_unicode_ci DEFAULT NULL,
    `improvement` text COLLATE utf8_unicode_ci DEFAULT NULL,
    `public` int(1) COLLATE utf8_unicode_ci DEFAULT NULL,
    `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1
 */