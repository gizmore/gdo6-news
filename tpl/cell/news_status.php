<?php
use GDO\News\GDT_NewsStatus;
use GDO\UI\GDT_Panel;
use GDO\UI\GDT_Label;
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
$lbl = GDT_Label::make()->icon($icon)->label($lbl);

echo $lbl->renderCell();
