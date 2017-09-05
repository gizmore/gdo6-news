<?php
namespace GDO\News;

use GDO\DB\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\Language\GDT_Language;
use GDO\Mail\GDT_Email;
use GDO\Mail\GDT_EmailFormat;
use GDO\Type\GDT_Int;
use GDO\User\GDT_User;
use GDO\User\GDO_User;

final class GDO_Newsletter extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('newsletter_id'),
			GDT_Int::make('newsletter_news')->unsigned(), # Last received newsletter for cronjob via web state :P
			GDT_User::make('newsletter_user')->unique(),
			GDT_Email::make('newsletter_email')->unique(),
			GDT_Language::make('newsletter_lang')->notNull(),
		    GDT_EmailFormat::make('newsletter_fmt')->notNull(),
		);
	}
	
	public function gdoHashcode()
	{
		return self::gdoHashcodeS($this->getVars(['newsletter_id', 'newsletter_user', 'newsletter_email']));
	}
	
	public static function getByEmail(string $email=null) { return self::getBy('newsletter_email', $email); }
	
	public static function getByUser(GDO_User $user) { return self::getBy('newsletter_user', $user->getID()); }
	
	public static function hasSubscribed(GDO_User $user) { return !!self::getByUser($user); }
	
	public static function hasSubscribedMail(string $email=null) { return !!self::getByEmail($email); }
	
	
	/**
	 * @return GDO_User
	 */
	public function getUser() { return $this->getValue('newsletter_user'); }
	public function getUserID() { return $this->getVar('newsletter_user'); }
	public function hasUser() { return $this->getUserID() !== null; }
	public function getLangISO() { return $this->getVar('newsletter_lang'); }
	public function getMail() { return $this->getValue('newsletter_email'); }
	
}
