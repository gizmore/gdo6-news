<?php
namespace GDO\News\Method;

use GDO\Core\MethodAdmin;
use GDO\News\Module_News;
use GDO\News\GDO_News;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_EditButton;

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
	
	public function gdoHeaders()
	{
		return array_merge(array(
			GDT_EditButton::make(),
		), parent::gdoHeaders());
	}
	
	public function beforeExecute()
	{
	    $this->renderNavBar();
	    Module_News::instance()->renderAdminTabs();
	}

}
