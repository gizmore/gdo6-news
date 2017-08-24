<?php
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;

$bar = GDO_Bar::make('bar');
$bar->addFields(array(
	GDO_Link::make('link_overview')->href(href('News', 'Admin')),
	GDO_Link::make('link_write_news')->href(href('News', 'Write')),
	GDO_Link::make('link_newsletters')->href(href('News', 'Newsletters')),
));
echo $bar->renderCell();
