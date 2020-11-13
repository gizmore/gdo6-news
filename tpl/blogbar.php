<?php
use GDO\UI\GDT_Bar;
use GDO\News\GDO_News;
use GDO\Category\GDO_Category;
/** @var $bar GDT_Bar **/

$table = GDO_News::table();
$query = $table->select()->order('news_created', 0);
$result = $query->exec();
// $nocat = [];
$categorized = [];

while ($news = $table->fetch($result))
{
	if (!($cat = $news->getCategoryID()))
	{
		$cat = "0";
	}
	if (!isset($categorized[$cat]))
	{
		$categorized[$cat] = [];
	}
	$categorized[$cat][] = $news;
}


printf('<div class="gdo-news-blogbar">');
foreach ($categorized as $cat => $items)
{
	if ($category = GDO_Category::getById($cat))
	{
		printf('<div class="gdo-category-title">%s</div>', $category->displayName());
	}
	else
	{
		printf('<div class="gdo-category-title">%s</div>', t('cat_news'));
	}
	printf('<ol>');
	foreach ($items as $news)
	{
		printf('<li><a href="%s">%s&nbsp;–&nbsp;%s</a></li>', html($news->href_view()), $news->displayDay(), $news->getTitle());
	}
	printf('</ol>');
}
printf('</div>');
