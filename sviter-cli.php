<?php
# This is Sviter command-line interface (CLI)
# Programmed by Rei Ayanami, http://animuchan.net/
# Licensed under the GNU General Public License (GPL) Version 2
require_once('simplepie.php');
require_once('settings.php');

define('api_url', 'http://api.twitter.com/1/statuses/user_timeline.rss?screen_name=');

$feed = new SimplePie();

$feed->set_feed_url(api_url.sviter_username);
$feed->init();
$feed->handle_content_type();

foreach ($feed->get_items() as $item) {
	printf("---\n%s\n%s\n", $item->get_title(), $item->get_permalink());
}
