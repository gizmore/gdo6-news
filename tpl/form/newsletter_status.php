<?php
use GDO\News\GDO_NewsletterStatus;
use GDO\News\Newsletter;
use GDO\UI\GDO_Link;
$field instanceof GDO_NewsletterStatus;
?>
<?php $user = $field->getUser(); ?>
<?php
if ($user->isMember())
{
	$linkSettings = GDO_Link::anchor(href('Account', 'Form'), t('link_mail_settings'));
	if (Newsletter::hasSubscribed($user))
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
	$field->icon('priority_high');
	$field->label('newsletter_sub_guest_unknown');
}
?>
<div class="gdo-label"><?= $field->htmlIcon() . ' ' . $field->label; ?></div>
