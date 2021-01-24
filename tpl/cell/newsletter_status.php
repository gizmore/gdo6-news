<?php
use GDO\News\GDT_NewsletterStatus;
use GDO\News\GDO_Newsletter;
use GDO\UI\GDT_Link;

/** @var $field GDT_NewsletterStatus **/
$user = $field->getUser();

if ($user->isMember())
{
	$linkSettings = GDT_Link::anchor(href('Account', 'Form'), t('link_mail_settings'));
	if (GDO_Newsletter::hasSubscribed($user))
	{
		$field->icon('check');
		$field->text('newsletter_info_subscribed', [$linkSettings]);
	}
	else
	{
		$field->icon('block');
		$field->text('newsletter_info_not_subscribed', [$linkSettings]);
	}
}
else
{
	$field->icon('alert');
	$field->text('newsletter_sub_guest_unknown');
}
?>
<div class="gdt-paragraph"><?= $field->htmlIcon() . ' ' . $field->renderText(); ?></div>
