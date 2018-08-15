<?php
namespace GDO\News\Method;

use GDO\Core\Method;
use GDO\News\GDO_News;
use GDO\News\RSS;

final class RSSFeed extends Method
{
	public function execute()
	{
		$query = GDO_News::table()->select()->limit(10);
		$query->where("news_visible")->order('news_created', false);
		$items = $query->exec()->fetchAllObjects();
		
		$sitename = sitename();
		$feed = new RSS(
			t('newsfeed_title', [$sitename]),
			t('newsfeed_descr', [$sitename]),
			$items,
			url('News', 'List'),
			url('News', 'RSSFeed'));
		die($feed->render());
	}
}
