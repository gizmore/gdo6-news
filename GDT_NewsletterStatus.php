<?php
namespace GDO\News;

use GDO\Template\GDT_Template;
use GDO\UI\GDT_Label;
use GDO\User\User;
use GDO\Form\WithIcon;

final class GDT_NewsletterStatus extends GDT_Label
{
    use WithIcon;
    
	public function renderCell()
	{
		return GDT_Template::php('News', 'cell/newsletter_status.php', ['field'=>$this]);
	}
	
	public function renderForm()
	{
		return GDT_Template::php('News', 'form/newsletter_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->gdo;
	}
}