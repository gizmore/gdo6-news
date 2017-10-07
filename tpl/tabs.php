<?php
# Navbar
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;

$user = GDO_User::current();
$bar = GDT_Bar::make();
$bar->addFields(array(
    GDT_Link::make('link_newsletter')->href(href('News', 'NewsletterAbbo'))->icon('add_alert'),
    GDT_Link::make('link_newsfeed')->href(href('News', 'RSSFeed'))->icon('add_alert'),
));
if ($user->hasPermission('staff'))
{
    $bar->addField(GDT_Link::make('link_write_news')->href(href('News', 'Write'))->icon('edit'));
}
echo $bar->render();
