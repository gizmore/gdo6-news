<?php
namespace GDO\News;

use GDO\Core\GDT_Template;
use GDO\UI\GDT_Paragraph;
use GDO\User\GDO_User;
use GDO\UI\WithIcon;

final class GDT_NewsletterStatus extends GDT_Paragraph
{
	use WithIcon;
	
	public function renderCell()
	{
		return GDT_Template::php('News', 'cell/newsletter_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return GDO_User
	 */
	public function getUser()
	{
		return $this->gdo;
	}
}
