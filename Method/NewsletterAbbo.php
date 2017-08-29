<?php
namespace GDO\News\Method;

use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Enum;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\Language\GDT_Language;
use GDO\Language\Trans;
use GDO\Mail\GDT_Email;
use GDO\Mail\GDT_EmailFormat;
use GDO\News\GDT_NewsletterStatus;
use GDO\News\Module_News;
use GDO\News\Newsletter;
use GDO\User\User;
/**
 * Susbscribe to the newsletter.
 * @author gizmore
 * @see News
 * @see Newsletter
 * @see News_Send
 */
final class NewsletterAbbo extends MethodForm
{
	public function isGuestAllowed()
	{
		return Module_News::instance()->cfgGuestNewsletter();
	}
	
	public function isUserRequired()
	{
		return false;
	}
	
	public function execute()
	{
	    $tabs = Module_News::instance()->renderTabs();
	    return $tabs->add($this->templateNewsletter());
	}
	
	public function templateNewsletter()
	{
		$tVars = array(
			'form' => $this->getForm(),
			'response' => parent::execute(),
		);
		return $this->templatePHP('newsletter.php', $tVars);
	}
	
	public function createForm(GDT_Form $form)
	{
		$user = User::current();
		$mem = $user->isMember();
		$subscribed = $mem ? Newsletter::hasSubscribed($user) : true;
		
		$form->addFields(array(
			GDT_NewsletterStatus::make('status')->gdo($user),
			GDT_Enum::make('yn')->enumValues('yes', 'no')->initial($subscribed?'yes':'no')->label('newsletter_subscribed')->writable($mem),
		    GDT_EmailFormat::make('newsletter_fmt')->initial($mem?$user->getMailFormat():GDT_EmailFormat::HTML)->writable(!$mem),
		    GDT_Language::make('newsletter_lang')->initial($mem?$user->getLangISO():Trans::$ISO)->writable(!$mem),
		    GDT_Email::make('newsletter_email')->initial($user->getMail())->writable(!$mem),
			GDT_Submit::make(),
			GDT_AntiCSRF::make(),
		));
	}
	public function formValidated(GDT_Form $form)
	{
		return $this->formAction($form)->add($this->renderPage());
	}
	
	public function formAction(GDT_Form $form)
	{
		$user = User::current();
		$oldsub = $user->isMember() ? 
			Newsletter::hasSubscribed($user) : 
			false;
		
		if ($form->getFormVar('yn') === 'yes')
		{
			if ($user->isMember())
			{
				if ($oldsub)
				{
					return $this->error('err_newsletter_already_subscribed');
				}
				$initial = array('newsletter_user' => $user->getID());
			}
			elseif (null === ($email = $form->getFormVar('newsletter_email')))
			{
			    return $this->error('err_newsletter_no_email');
			}
			elseif (Newsletter::hasSubscribedMail($email))
			{
				return $this->error('err_newsletter_already_subscribed');
			}
			else
			{
				$initial = $form->getFormData();
			}
			Newsletter::blank($initial)->insert();
			return $this->message('msg_newsletter_subscribed');
		}
		elseif (!$oldsub)
		{
			return $this->error('err_newsletter_not_subscribed');
		}
		else
		{
			Newsletter::table()->deleteWhere('newsletter_user='.$user->getID())->exec();
			return $this->message('msg_newsletter_unsubscribed');
		}
	}
}
