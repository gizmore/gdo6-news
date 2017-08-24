<?php
namespace GDO\News;

use GDO\Template\GDO_Template;
use GDO\UI\GDO_Label;
use GDO\User\User;
use GDO\Form\WithIcon;

final class GDO_NewsletterStatus extends GDO_Label
{
    use WithIcon;
    
	public function renderCell()
	{
		return GDO_Template::php('News', 'cell/newsletter_status.php', ['field'=>$this]);
	}
	
	public function renderForm()
	{
		return GDO_Template::php('News', 'form/newsletter_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->gdo;
	}
}