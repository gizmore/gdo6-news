<?php
namespace GDO\News;
use GDO\Core\GDO;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_Object;
use GDO\Language\GDT_Language;
use GDO\UI\GDT_Message;
use GDO\UI\GDT_Title;
final class GDO_NewsText extends GDO
{
	###########
	### GDO ###
	###########
	public function gdoCached() { return false; }
	public function gdoColumns()
	{
		return array(
			GDT_Object::make('newstext_news')->table(GDO_News::table())->primary(),
			GDT_Language::make('newstext_lang')->primary(),
			GDT_Title::make('newstext_title')->notNull()->max(255),
			GDT_Message::make('newstext_message'),
			GDT_CreatedAt::make('newstext_created'),
			GDT_CreatedBy::make('newstext_creator'),
		);
	}
	##############
	### Getter ###
	##############
	public function getTitle() { return $this->getVar('newstext_title'); }
	public function getMessage() { return $this->getVar('newstext_message'); }
}
