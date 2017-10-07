<?php
namespace GDO\News;
use GDO\UI\WithIcon;
use GDO\Core\GDT_Template;
use GDO\UI\GDT_Label;
final class GDT_NewsStatus extends GDT_Label
{
    use WithIcon;
    
    public function renderCell()
	{
		return GDT_Template::php('News', 'cell/news_status.php', ['field'=>$this]);
	}
	
	/**
	 * @return GDO_News
	 */
	public function getNews()
	{
		return $this->gdo;
	}
}
