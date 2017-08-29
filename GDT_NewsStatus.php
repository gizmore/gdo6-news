<?php
namespace GDO\News;

use GDO\Form\WithIcon;
use GDO\Template\GDT_Template;
use GDO\UI\GDT_Label;

final class GDT_NewsStatus extends GDT_Label
{
    use WithIcon;
    
    public function renderCell()
	{
		return GDT_Template::php('News', 'cell/news_status.php', ['field'=>$this]);
	}
	
	public function renderForm()
	{
		return GDT_Template::php('News', 'form/news_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return News
	 */
	public function getNews()
	{
		return $this->gdo;
	}
}