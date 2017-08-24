<?php 
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;
$navbar instanceof GDO_Bar;
$navbar->addFields(array(
	GDO_Link::make('link_news')->href(href('News', 'List'))->label('link_news'),
));
