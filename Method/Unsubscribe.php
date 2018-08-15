<?php
namespace GDO\News\Method;

use GDO\Core\Method;
use GDO\Util\Common;
use GDO\News\GDO_Newsletter;

/**
 * Unsubscribe newsletter via token.
 * @author gizmore
 * @since 2.0
 */
final class Unsubscribe extends Method
{
	public function isAlwaysTransactional() { return true; }
	
	public function execute()
	{
		if ( (!($newsletter = GDO_Newsletter::getById(Common::getRequestString('id')))) ||
			 ($newsletter->gdoHashcode() !== Common::getRequestString('token')) )
		{
			return $this->error('err_newsletter_not_subscribed');
		}
		$newsletter->delete();
		return $this->message('msg_newsletter_unsubscribed');
	}
}
