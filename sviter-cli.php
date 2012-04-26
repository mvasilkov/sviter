<?php
# This is Sviter command-line interface (CLI)
# Programmed by Rei Ayanami, http://animuchan.net/
# Licensed under the GNU General Public License (GPL) Version 2
require_once('rb.php');
require_once('simplepie.php');
require_once('settings.php');

define('api_url', 'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=');

$feed = new SimplePie();

$feed->set_feed_url(api_url.sviter_username);
$feed->init();
$feed->handle_content_type();

R::setup('mysql:host=localhost;dbname='.database_name, database_user, database_password);

$unique = array(array('link'));
$new_rec = 0;

foreach ($feed->get_items() as $item) {
	$obj = R::dispense('sviter_post');

	$obj->text = $item->get_title();
	$obj->link = $item->get_permalink();

	$obj->setMeta('buildcommand.unique', $unique);

	try {
		R::store($obj);
		++$new_rec;
	}
	catch (Exception $not_used) {
	}
}

echo "New records: $new_rec\n";
