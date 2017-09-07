<?php
namespace GDO\News\Method;
use GDO\Admin\MethodAdmin;
use GDO\Table\MethodQueryTable;
use GDO\News\Module_News;
use GDO\News\GDO_Newsletter;
/**
 * Table of newsletter subscriptions.
 * @author gizmore
 * @version 6.0
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
	
	public function execute()
	{
	    return $this->renderNavBar('News')->
	    add(Module_News::instance()->renderAdminTabs())->
	    add(parent::execute());
	}
	
}