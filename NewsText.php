<?php
namespace GDO\News;

use GDO\DB\GDO;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Language\GDT_Language;
use GDO\Type\GDT_Message;
use GDO\Type\GDT_String;

final class NewsText extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoCached() { return false; }
	public function gdoColumns()
	{
		return array(
			GDT_Object::make('newstext_news')->table(News::table())->primary(),
			GDT_Language::make('newstext_lang')->primary(),
			GDT_String::make('newstext_title')->notNull(),
			GDT_Message::make('newstext_message')->notNull(),
			GDT_CreatedAt::make('newstext_created'),
			GDT_CreatedBy::make('newstext_creator'),
		);
	}
	
	public function getTitle() { return $this->getVar('newstext_title'); }
	public function getMessage() { return $this->getVar('newstext_message'); }
	
}
