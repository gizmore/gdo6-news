<?php
use GDO\News\Module_News;
use GDO\User\GDO_User;

$user = GDO_User::current();
$module = Module_News::instance();

echo $module->renderTabs();

# List with cards
echo $response->getHTML();
