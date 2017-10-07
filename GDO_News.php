<?php
namespace GDO\News;

use GDO\Category\GDO_Category;
use GDO\Category\GDT_Category;
use GDO\Comment\CommentedObject;
use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\Date\GDT_DateTime;
use GDO\Language\Trans;
use GDO\Core\GDT_Template;
use GDO\DB\GDT_Checkbox;
use GDO\User\GDO_User;
/**
 * News database.
 * @author gizmore
 * @version 5.0
 * @since 2.0
 * @see NewsText
 */
final class GDO_News extends GDO implements RSSItem
{
	################
	### Comments ###
	################
	use CommentedObject;
	public function gdoCommentTable() { return GDO_NewsComments::table(); }
	public function gdoCommentsEnabled() { return $this->isVisible() && $this->gdoCommentTable()->gdoEnabled(); }
	public function gdoCanComment(GDO_User $user) { return true; }
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('news_id'),
		    GDT_Category::make('news_category')->emptyInitial(t('no_category')),
			GDT_Checkbox::make('news_visible')->notNull()->initial('0'),
			GDT_DateTime::make('news_send')->label('news_sending'), # is in queue? (sending)
			GDT_DateTime::make('news_sent')->label('news_sent'), # is out of queue? (sent)
			GDT_CreatedAt::make('news_created'),
			GDT_CreatedBy::make('news_creator'),
		);
	}
	
	##############
	### Getter ###
	##############
	public function getID() { return $this->getVar('news_id'); }
	public function isSent() { return $this->getSentDate() !== null; }
	public function isSending() { return ($this->getSentDate() === null) && ($this->getSendDate() !== null); }
	
	/**
	 * @return GDO_Category
	 */
	public function getCategory() { return $this->getValue('news_category'); }
	public function getCategoryID() { return $this->getVar('news_category'); }
	public function isVisible() { return $this->getVar('news_visible') === '1'; }
	public function getSendDate() { return $this->getVar('news_send'); }
	public function getSentDate() { return $this->getVar('news_sent'); }
	public function getCreateDate() { return $this->getVar('news_created'); }
	public function displayDay() { return tt($this->getCreateDate(), 'day'); }
	
	/**
	 * @return GDO_User
	 */
	public function getCreator() { return $this->getValue('news_creator'); }
	public function getCreatorID() { return $this->getVar('news_creator'); }
	
	### Perm ###
	public function canEdit(GDO_User $user) { return $user->isStaff(); }
	
	public function href_edit() { return href('News', 'Write', '&id='.$this->getID()); }
	public function href_view() { return href('News', 'View', '&id='.$this->getID()); }
	
	#############
	### Texts ###
	#############
	public function getTitle() { return $this->getTextVar('newstext_title'); }
	public function getMessage() { return $this->getTextVar('newstext_message'); }

	public function getTitleISO($iso) { return $this->getTextVarISO('newstext_title', $iso); }
	public function getMessageISO($iso) { return $this->getTextVarISO('newstext_message', $iso); }
	
	public function getTextVar($key) { return $this->getText(Trans::$ISO)->getVar($key); }
	public function getTextValue($key) { return $this->getText(Trans::$ISO)->getValue($key); }
	
	public function getTextVarISO($key, $iso) { return $this->getText($iso)->getVar($key); }
	public function getTextValueISO($key, $iso) { return $this->getText($iso)->getValue($key); }
	
	public function displayMessage()
	{
		$text = $this->getTxt();
		return $text->gdoColumn('newstext_message')->value($text->getMessage())->renderCell();
	}

	public function renderCard() { return GDT_Template::php('News', 'card/gwf_news.php', ['gdo'=>$this]); }
	###################
	### Translation ###
	###################
	/**
	 * @return GDO_NewsText
	 */
	public function getTxt()
	{
		return $this->getText(Trans::$ISO);
	}
	
	/**
	 * @param string $iso
	 * @return GDO_NewsText
	 */
	public function getText($iso, $fallback=true)
	{
		$texts = $this->getTexts();
		if (isset($texts[$iso]))
		{
			return $texts[$iso];
		}
		if ($fallback)
		{
			return isset($texts[GWF_LANGUAGE]) ? $texts[GWF_LANGUAGE] : array_shift($texts);
		}
	}

	/**
	 * @return GDO_NewsText[]
	 */
	public function getTexts()
	{
		if (null === ($cache = $this->tempGet('newstexts')))
		{
		    $query = GDO_NewsText::table()->select('newstext_lang, gdo_newstext.*');
			$query->where("newstext_news=".$this->getID());
			$cache = $query->exec()->fetchAllArrayAssoc2dObject();
			$this->tempSet('newstexts', $cache);
			$this->recache();
		}
		return $cache;
	}
	
	###############
	### RSSItem ###
	###############
    public function getRSSTitle() { return $this->getTitle(); }
    public function getRSSPubDate() { return $this->getValue('news_created'); }
    public function getRSSGUID() { return $this->gdoHashcode(); }
    public function getRSSLink() { return url('News', 'Comments', '&id='.$this->getID()); }
    public function getRSSDescription() { return $this->getMessage(); }
	
}
