<?php
namespace GDO\News\Method;

use GDO\Core\MethodAdmin;
use GDO\Table\MethodQueryTable;
use GDO\News\Module_News;
use GDO\News\GDO_Newsletter;

/**
 * Table of newsletter subscriptions.
 * @author gizmore
 * @version 6.10
 * @since 6.0
 */
final class Newsletters extends MethodQueryTable
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	public function getQuery()
	{
		return GDO_Newsletter::table()->select();
	}
	
	public function beforeExecute()
	{
	    $this->renderNavBar();
	    Module_News::instance()->renderAdminTabs();
	}
	
}
