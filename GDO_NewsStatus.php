<?php
namespace GDO\News;

use GDO\Form\WithIcon;
use GDO\Template\GDO_Template;
use GDO\UI\GDO_Label;

final class GDO_NewsStatus extends GDO_Label
{
    use WithIcon;
    
    public function renderCell()
	{
		return GDO_Template::php('News', 'cell/news_status.php', ['field'=>$this]);
	}
	
	public function renderForm()
	{
		return GDO_Template::php('News', 'form/news_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return News
	 */
	public function getNews()
	{
		return $this->gdo;
	}
}