<?php 
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
$navbar instanceof GDT_Bar;
$navbar->addFields(array(
	GDT_Link::make('link_news')->href(href('News', 'List'))->label('link_news'),
));
