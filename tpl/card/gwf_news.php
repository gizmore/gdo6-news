<?php
use GDO\News\News;
use GDO\UI\GDO_Button;
use GDO\UI\GDO_IconButton;
use GDO\UI\GDO_Link;
use GDO\User\User;

$gdo instanceof News;
?>
<?php
$user = User::current();
$comments = $gdo->gdoCommentTable();
?>
<md-card flex layout-fill class="md-whiteframe-8dp">
  <md-card-title>
    <md-card-title-text>
      <span class="md-headline">
        <div>“<?= html($gdo->getTitle()); ?>” - <?= $gdo->getCreator()->renderCell(); ?></div>
        <div class="gdo-card-date"><?= t($gdo->getCreateDate()); ?></div>
      </span>
    </md-card-title-text>
  </md-card-title>
  <gdo-div></gdo-div>
  <md-card-content flex>
    <?= $gdo->displayMessage(); ?>
  </md-card-content>
  <gdo-div></gdo-div>
  <md-card-actions layout="row" layout-align="end center">
<?php
if ($gdo->canEdit($user))
{
	echo GDO_IconButton::make()->href(href('News', 'Write', '&id='.$gdo->getID()))->icon('edit')->renderCell(); 
}
if ($gdo->gdoCommentsEnabled())
{
    
    $count = $gdo->getCommentCount();
    echo GDO_Link::make('link_comments')->label('link_comments', [$count])->icon('feedback')->href(href('News', 'Comments', '&id='.$gdo->getID()))->renderCell();
    if ($gdo->gdoCanComment($user))
    {
    	echo GDO_Button::make('btn_write_comment')->href(href('News', 'WriteComment', '&id='.$gdo->getID()))->icon('reply')->renderCell();
    }
}
?>
  </md-card-actions>

</md-card>
