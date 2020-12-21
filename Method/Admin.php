<?php
namespace GDO\News\Method;

use GDO\Core\MethodAdmin;
use GDO\News\Module_News;
use GDO\News\GDO_News;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_EditButton;
use GDO\UI\GDT_Title;

/**
 * Overview of news entries.
 * @author gizmore
 * @version 6.10
 */
final class Admin extends MethodQueryTable
{
	use MethodAdmin;
	
	public function gdoTable() { return GDO_News::table(); }
	
	public function getPermission() { return 'staff'; }
	
	public function getDefaultOrder() { return 'news_created'; }
	public function getDefaultOrderDir() { return false; }
	
	public function gdoHeaders()
	{
	    $t = $this->gdoTable();
		return [
			GDT_EditButton::make(),
		    $t->gdoColumn('news_category'),
		    GDT_Title::make('newstext_title'),
		    $t->gdoColumn('news_category'),
		    $t->gdoColumn('news_visible'),
		    $t->gdoColumn('news_send'),
		    $t->gdoColumn('news_sent'),
		    $t->gdoColumn('news_created'),
		    $t->gdoColumn('news_creator'),
		]; 
	}
	
	public function getQuery()
	{
	    $query = parent::getQuery()->select('nt.*');
	    $query->joinObject('newstext');
	    return $query;
	}
	
	public function beforeExecute()
	{
	    $this->renderNavBar();
	    Module_News::instance()->renderAdminTabs();
	}

}
