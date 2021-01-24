<?php /** @var $gdo \GDO\News\GDO_News **/
use GDO\UI\GDT_Button;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_HTML;
use GDO\UI\GDT_Label;
use GDO\UI\GDT_Headline;

$user = $gdo->getCreator();

$card = GDT_Card::make('news')->gdo($gdo);

$card->creatorHeader();

$card->title(GDT_Headline::make()->textRaw($gdo->getTitle()));

$card->addField(GDT_HTML::withHTML($gdo->displayMessage()));

if ($gdo->canEdit($user))
{
	$card->actions()->addField(GDT_Button::make('btn_edit')->href(href('News', 'Write', '&id='.$gdo->getID()))->icon('edit'));
}

if ($gdo->gdoCommentsEnabled())
{
	$count = $gdo->getCommentCount();
	$card->actions()->addField(GDT_Button::make('link_comments')->label('link_comments', [$count])->icon('quote')->href(href('News', 'Comments', '&id='.$gdo->getID())));
	if ($gdo->gdoCanComment($user))
	{
		$card->actions()->addField(GDT_Button::make('btn_write_comment')->href(href('News', 'WriteComment', '&id='.$gdo->getID()))->icon('reply'));
	}
}

echo $card->render();
