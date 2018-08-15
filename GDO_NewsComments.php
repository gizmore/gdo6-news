<?php
namespace GDO\News;

use GDO\Comment\GDO_CommentTable;

final class GDO_NewsComments extends GDO_CommentTable
{
	public function gdoCommentedObjectTable() { return GDO_News::table(); }
	public function gdoAllowFiles() { return false; }
	public function gdoEnabled() { return Module_News::instance()->cfgComments(); }
}
