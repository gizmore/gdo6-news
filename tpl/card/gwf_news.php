<?php /** @var $gdo \GDO\News\GDO_News **/
use GDO\Profile\GDT_ProfileLink;
use GDO\UI\GDT_Button;
use GDO\UI\GDT_IconButton;
use GDO\UI\GDT_Link;
use GDO\User\GDO_User;
use GDO\UI\GDT_Menu;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_HTML;
use GDO\UI\WithHTML;

$user = GDO_User::current();
$comments = $gdo->gdoCommentTable();

$card = GDT_Card::make('news');

$avatar = GDT_ProfileLink::make()->forUser($user)->withNickname()->render();
$date = tt($gdo->getCreateDate());
$titleText = $gdo->getTitle();
$title=<<<EOT
<div>
<div>{$avatar}</div>
<div>{$date}</div>
</div>
EOT;
$card->title($title);

$card->addField(GDT_HTML::withHTML("$titleText<br/>".$gdo->displayMessage()));


if ($gdo->canEdit($user))
{
	$card->actions()->addField(GDT_IconButton::make()->href(href('News', 'Write', '&id='.$gdo->getID()))->icon('edit'));
}

if ($gdo->gdoCommentsEnabled())
{
    $count = $gdo->getCommentCount();
    $card->actions()->addField(GDT_Link::make('link_comments')->label('link_comments', [$count])->icon('quote')->href(href('News', 'Comments', '&id='.$gdo->getID())));
    if ($gdo->gdoCanComment($user))
    {
    	$card->actions()->addField(GDT_Button::make('btn_write_comment')->href(href('News', 'WriteComment', '&id='.$gdo->getID()))->icon('reply'));
    }
}

echo $card->render();
