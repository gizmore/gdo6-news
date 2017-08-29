<?php
namespace GDO\News\Method;

use GDO\Comment\Comments_Write;
use GDO\News\Module_News;
use GDO\News\GDO_NewsComments;

final class WriteComment extends Comments_Write
{
    public function gdoCommentsTable() { return GDO_NewsComments::table(); }
	
	public function hrefList() { return href('News', 'Comments', '&id='.$this->object->getID()); }
	
	public function isGuestAllowed() { return Module_News::instance()->cfgGuestComments(); }
}
