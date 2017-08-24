<?php
namespace GDO\News;

use GDO\DB\GDO;
use GDO\DB\GDO_CreatedAt;
use GDO\DB\GDO_CreatedBy;
use GDO\DB\GDO_Object;
use GDO\Language\GDO_Language;
use GDO\Type\GDO_Message;
use GDO\Type\GDO_String;

final class NewsText extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoCached() { return false; }
	public function gdoColumns()
	{
		return array(
			GDO_Object::make('newstext_news')->table(News::table())->primary(),
			GDO_Language::make('newstext_lang')->primary(),
			GDO_String::make('newstext_title')->notNull(),
			GDO_Message::make('newstext_message')->notNull(),
			GDO_CreatedAt::make('newstext_created'),
			GDO_CreatedBy::make('newstext_creator'),
		);
	}
	
	public function getTitle() { return $this->getVar('newstext_title'); }
	public function getMessage() { return $this->getVar('newstext_message'); }
	
}
