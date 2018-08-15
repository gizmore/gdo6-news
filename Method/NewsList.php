<?php
namespace GDO\News\Method;

use GDO\DB\Query;
use GDO\News\Module_News;
use GDO\News\GDO_News;
use GDO\Table\MethodQueryCards;

class NewsList extends MethodQueryCards
{
	public function gdoTable() { return GDO_News::table(); }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestNews(); }
	
	public function gdoQuery()
	{
		$query = parent::gdoQuery();
		return $this->filterNewsQuery($query);
	}
	
	public function filterNewsQuery(Query $query)
	{
		return $query->where('news_visible');
	}
	
	public function execute()
	{
		$tVars = array(
			'response' => parent::execute(),
		);
		return $this->templatePHP('news.php', $tVars);
	}
	
}
