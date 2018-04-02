<?php
namespace GDO\News;

use GDO\Core\GDO_Module;
use GDO\UI\GDT_Bar;
use GDO\DB\GDT_Checkbox;
use GDO\UI\GDT_Link;
use GDO\Core\GDT_Template;
use GDO\UI\GDT_Button;

final class Module_News extends GDO_Module
{
	public $module_version = "6.01";
	
	##############
	### Module ###
	##############
	public function href_administrate_module() { return href('News', 'Admin'); }
	public function onLoadLanguage() { $this->loadLanguage('lang/news'); }
	public function getClasses()
	{
	    return array(
	        'GDO\News\GDO_News',
	        'GDO\News\GDO_NewsText', 
	        'GDO\News\GDO_NewsComments',
    	    'GDO\News\GDO_Newsletter');
	}

	##############
	### Config ###
	##############
	public function getConfig()
	{
		return array(
		    GDT_Checkbox::make('news_blogbar')->initial('0'),
		    GDT_Checkbox::make('news_comments')->initial('1'),
		    GDT_Checkbox::make('news_guests')->initial('1'),
			GDT_Checkbox::make('newsletter_guests')->initial('1'),
			GDT_Checkbox::make('news_guest_comments')->initial('1'),
		);
	}
	public function cfgBlogbar() { return $this->getConfigValue('news_blogbar'); }
	public function cfgComments() { return $this->getConfigValue('news_comments'); }
	public function cfgGuestNews() { return $this->getConfigValue('news_guests'); }
	public function cfgGuestNewsletter() { return $this->getConfigValue('newsletter_guests'); }
	public function cfgGuestComments() { return $this->getConfigValue('news_guest_comments'); }
	
	############
	### Navs ###
	############
	public function renderTabs()
	{
	    return $this->responsePHP('tabs.php');
	}
	
	public function renderAdminTabs()
	{
	    return $this->responsePHP('admin_tabs.php');
	}

	public function hookLeftBar(GDT_Bar $navbar)
	{
	    $navbar->addFields(array(
	    	GDT_Link::make('link_news')->href(href('News', 'NewsList'))->label('link_news'),
	    ));
	    if ($this->cfgBlogbar())
	    {
	        $navbar->addField(GDT_Template::make()->template('News', 'blogbar.php', ['bar'=>$navbar]));
	    }
	}
	
	public function hookTopBar(GDT_Bar $navbar)
	{
	}
}
