<?php
use GDO\News\Module_News;
use GDO\User\User;

$user = User::current();
$module = Module_News::instance();

echo $module->renderTabs();

# List with cards
echo $response->getHTML();
