<?php
namespace GDO\News;

use GDO\Language\Trans;
use GDO\Core\Application;
use GDO\Core\GDT_Template;
use GDO\Net\GDT_Url;
use GDO\Date\Time;

final class RSS
{
	private $title;
	private $descr;
	private $items;
	private $webURL;
	private $feedURL;
		
	public static function displayDate($time=null)
	{
	    return date('r', $time===null ? Application::$TIME : $time);
	}
	
	public static function displayCData($data)
	{
		return '<![CDATA['.htmlspecialchars($data).']]>';
	}
	
	public function __construct($title, $descr, array $items, $webURL, $feedURL)
	{
		$this->title = $title;
		$this->descr = $descr;
		$this->items = $items;
		$this->webURL = $webURL;
		$this->feedURL = $feedURL;
	}
	
	public function setWebURL($webURL)
	{
		$this->webURL = $webURL;
	}
	
	public function setFeedURL($feedURL)
	{
		$this->feedURL = $feedURL;
	}
	
	public function setTitle($title)
	{
		$this->title = $title;
	}
	
	public function setDescription($descr)
	{
		$this->descr = $descr;
	}
	
	public function setItems(array $items)
	{
		$this->items = $items;
	}
	
	public function guessRSSDate()
	{
		if (count($this->items) === 0)
		{
			return Time::getTimestamp(GDO_SITECREATED);
		}
		else
		{
			$item = $this->items[0];
			return $item->getRSSPubDate();
		}
	}
	
	public function render()
	{
		header("Content-Type: application/xml; charset=UTF-8");
		
		$rss_date = self::displayDate($this->guessRSSDate());
		
		$tVars = array(
			'items' => $this->items,
			'title_link' => $this->feedURL,
			'feed_title' => $this->title,
			'feed_description' => $this->descr,
			'language' => Trans::$ISO,
			'image_url' => GDT_Url::absolute('/favicon.ico'),
			'image_link' => $this->webURL,
			'image_width' => '32',
			'image_height' => '32',
			'pub_date' => $rss_date,
			'build_date' => $rss_date,
		);
		
		return GDT_Template::php('News', 'rss.php', $tVars);
	}
	
}
