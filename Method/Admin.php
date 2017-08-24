<?php
namespace GDO\News\Method;

use GDO\Admin\MethodAdmin;
use GDO\News\Module_News;
use GDO\News\News;
use GDO\Table\MethodQueryTable;
use GDO\UI\GDO_EditButton;

final class Admin extends MethodQueryTable
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	public function getHeaders()
	{
		return array_merge(array(
			GDO_EditButton::make(),
		), parent::getHeaders());
	}
	
	public function getQuery()
	{
		return News::table()->select();
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
