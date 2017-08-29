<?php
namespace GDO\News\Method;

use GDO\News\GDO_News;
use GDO\Table\MethodQueryCard;

final class View extends MethodQueryCard
{
    public function gdoTable() { return GDO_News::table(); }
	
}
