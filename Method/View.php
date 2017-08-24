<?php
namespace GDO\News\Method;

use GDO\News\News;
use GDO\Table\MethodQueryCard;

final class View extends MethodQueryCard
{
	public function gdoTable() { return News::table(); }
	
}
