<?php
use GDO\News\GDT_NewsletterStatus;
use GDO\News\GDO_Newsletter;
use GDO\UI\GDT_Link;
$field instanceof GDT_NewsletterStatus;
?>
<?php $user = $field->getUser(); ?>
<?php
if ($user->isMember())
{
	$linkSettings = GDT_Link::anchor(href('Account', 'Form'), t('link_mail_settings'));
	if (GDO_Newsletter::hasSubscribed($user))
	{
		$field->icon('check');
		$field->label('newsletter_info_subscribed', [$linkSettings]);
	}
	else
	{
		$field->icon('block');
		$field->label('newsletter_info_not_subscribed', [$linkSettings]);
	}
}
else
{
	$field->icon('alert');
	$field->label('newsletter_sub_guest_unknown');
}
?>
<div class="gdo-label"><?= $field->htmlIcon() . ' ' . $field->displayLabel(); ?></div>
