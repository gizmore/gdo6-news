<?php
use GDO\News\GDT_NewsStatus;
use GDO\UI\GDT_Panel;
$field instanceof GDT_NewsStatus;
?>
<?php $news = $field->getNews(); ?>
<?php
$icon = 'pause';
$lbl = 'newsletter_status_waiting';
if ($news->isSent())
{
	$icon = 'done_all';
	$lbl = 'newsletter_status_sent';
}
elseif ($news->isSending())
{
	$icon = 'done';
	$lbl = 'newsletter_status_in_queue';
}
$field->icon($icon);
$field->label($lbl);

echo GDT_Panel::withHTML($field->htmlIcon() . ' ' . $field->displayLabel())->renderCell();
