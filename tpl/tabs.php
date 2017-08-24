<?php
# Navbar
use GDO\Template\GDO_Bar;
use GDO\UI\GDO_Link;
use GDO\User\User;

$user = User::current();
$bar = GDO_Bar::make();
$bar->addFields(array(
    GDO_Link::make('link_newsletter')->href(href('News', 'NewsletterAbbo'))->icon('add_alert'),
    GDO_Link::make('link_newsfeed')->href(href('News', 'RSSFeed'))->icon('add_alert'),
));
if ($user->hasPermission('staff'))
{
    $bar->addField(GDO_Link::make('link_write_news')->href(href('News', 'Write'))->icon('edit'));
}
echo $bar->render();
