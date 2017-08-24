<?php
namespace GDO\News;

use GDO\Core\Module;
use GDO\Template\GDO_Bar;
use GDO\Type\GDO_Checkbox;
use GDO\UI\GDO_Link;

final class Module_News extends Module
{
	public $module_version = "6.01";
	
	##############
	### Module ###
	##############
	public function getClasses() { return array('GDO\News\News', 'GDO\News\NewsText', 'GDO\News\NewsComments', 'GDO\News\Newsletter'); }
	public function onLoadLanguage() { $this->loadLanguage('lang/news'); }
	public function href_administrate_module() { return href('News', 'Admin'); }

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
			GDO_Checkbox::make('news_comments')->initial('1'),
			GDO_Checkbox::make('news_guests')->initial('1'),
			GDO_Checkbox::make('newsletter_guests')->initial('1'),
			GDO_Checkbox::make('news_guest_comments')->initial('1'),
		);
	}
	public function cfgComments() { return $this->getConfigValue('news_comments'); }
	public function cfgGuestNews() { return $this->getConfigValue('news_guests'); }
	public function cfgGuestNewsletter() { return $this->getConfigValue('newsletter_guests'); }
	public function cfgGuestComments() { return $this->getConfigValue('news_guest_comments'); }
	
	############
	### Navs ###
	############
	public function renderTabs()
	{
	    return $this->templatePHP('tabs.php');
	}
	
	public function renderAdminTabs()
	{
	    return $this->templatePHP('admin_tabs.php');
	}
	
	public function hookLeftBar(GDO_Bar $navbar)
	{
	    $navbar->addFields(array(
    	    GDO_Link::make('link_news')->href(href('News', 'NewsList'))->label('link_news'),
	    ));
	}
}
