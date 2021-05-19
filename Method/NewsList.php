<?php
namespace GDO\News\Method;

use GDO\News\Module_News;
use GDO\News\GDO_News;
use GDO\Table\MethodQueryCards;

class NewsList extends MethodQueryCards
{
    public function getTitleLangKey() { return 'link_news'; }
    
	public function gdoTable() { return GDO_News::table(); }
	
	public function useFetchInto() { return false; }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestNews(); }
	
	public function gdoHeaders()
	{
	    return $this->gdoTable()->getGDOColumns([
	        'news_creator', 'news_created']);
	}
	
	public function getDefaultOrder() { return 'news_created'; }
	public function getDefaultOrderDir() { return false; }
	
	public function getQuery()
	{
		return parent::getQuery()->where('news_visible')->joinObject('newstext');
	}
	
	public function beforeExecute()
	{
	    Module_News::instance()->renderTabs();
	}
	
}
