<?php
namespace GDO\News\Method;

use GDO\Admin\MethodAdmin;
use GDO\News\Module_News;
use GDO\News\GDO_News;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDT_EditButton;

final class Admin extends MethodQueryTable
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	public function getHeaders()
	{
		return array_merge(array(
			GDT_EditButton::make(),
		), parent::getHeaders());
	}
	
	public function getQuery()
	{
	    return GDO_News::table()->select();
	}
	
	public function execute()
	{
		return $this->renderNavBar('News')->add(Module_News::instance()->renderAdminTabs())->add(parent::execute());
	}
	
// 	public function filterNewsQuery(Query $query)
// 	{
// 		return $query;
// 	}
}
