<?php
namespace GDO\News\Method;

use GDO\Comment\Comments_Write;
use GDO\News\Module_News;
use GDO\News\GDO_NewsComments;
use GDO\User\GDO_User;

final class WriteComment extends Comments_Write
{
    public function gdoCommentsTable() { return GDO_NewsComments::table(); }
	
	public function hrefList() { return href('News', 'Comments', '&id='.$this->object->getID()); }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestComments(); }
	
	public function execute()
	{
	    $user = GDO_User::current();
	    $module = Module_News::instance();
	    if (!$module->cfgComments())
	    {
	        return $this->error('err_comments_disabled');
	    }
	    elseif ( (!$module->cfgGuestComments()) && (!$user->isMember()) )
	    {
	        return $this->error('err_guest_comments_disabled');
	    }
	    return parent::execute();
	}
}
