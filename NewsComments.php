<?php
namespace GDO\News;

use GDO\Comment\CommentTable;

final class NewsComments extends CommentTable
{
	public function gdoCommentedObjectTable() { return News::table(); }
	public function gdoAllowFiles() { return false; }
	public function gdoEnabled() { return Module_News::instance()->cfgComments(); }
	
	
}