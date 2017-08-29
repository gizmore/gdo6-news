<?php
namespace GDO\News\Method;

use GDO\Comment\Comments_List;
use GDO\News\Module_News;
use GDO\News\GDO_NewsComments;

final class Comments extends Comments_List
{
    public function gdoCommentsTable() { return GDO_NewsComments::table(); }
	public function hrefAdd() { return href('News', 'Comments', 'id='.$this->object->getID()); }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestNews(); }
	
}
