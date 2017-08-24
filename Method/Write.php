<?php
namespace GDO\News\Method;

use GDO\Admin\MethodAdmin;
use GDO\Core\Website;
use GDO\Date\Time;
use GDO\Form\GDO_AntiCSRF;
use GDO\Form\GDO_Form;
use GDO\Form\GDO_Submit;
use GDO\Form\MethodForm;
use GDO\Language\Module_Language;
use GDO\News\GDO_NewsStatus;
use GDO\News\Module_News;
use GDO\News\News;
use GDO\News\NewsText;
use GDO\Type\GDO_Message;
use GDO\Type\GDO_String;
use GDO\UI\GDO_Divider;
use GDO\UI\GDO_Tab;
use GDO\UI\GDO_Tabs;
use GDO\Util\Common;

/**
 * Write a news entry.
 * This is a bit more complex form with tabs for each edited language.
 * 
 * @see GDO_Tab
 * @see GDO_Tabs
 * @see News
 * @see GDO_Form
 * 
 * @author gizmore
 * @since 2.0
 * @version 5.0
 */
final class Write extends MethodForm
{
	use MethodAdmin;
	
	public function getPermission() { return 'staff'; }
	
	/**
	 * @var News
	 */
	private $news;
	
	public function init()
	{
		if ($id = Common::getRequestString('id'))
		{
			$this->news = News::table()->find($id);
		}
	}
	
	public function execute()
	{
		$response = parent::execute();
		$newstabs = Module_News::instance()->renderAdminTabs();
		return $this->renderNavBar('News')->add($newstabs)->add($response);
	}
	
	public function createForm(GDO_Form $form)
	{
		$news = News::table();
		
		# Category select
		$form->addFields(array(
			$news->gdoColumn('news_category'),
			GDO_Divider::make('div_texts'),
		));
		
		# Translation tabs
		$tabs = GDO_Tabs::make('tabs');
		foreach (Module_Language::instance()->cfgSupported() as $iso => $language)
		{
			# New tab
			$tab = GDO_Tab::make('tab_'.$iso)->rawLabel($language->displayName());

			# 2 Fields
			$primary = $iso === GWF_LANGUAGE;
			$title = GDO_String::make("iso][$iso][newstext_title")->label('title')->notNull($primary);
			$message = GDO_Message::make("iso][$iso][newstext_message")->label('message')->notNull($primary);
			if ($this->news)
			{ # Old values
				if ($text = $this->news->getText($iso, false))
				{
					$title->var($text->getTitle());
					$message->var($text->getMessage());
				}
			}
			# Add
			$tab->addField($title);
			$tab->addField($message);
			$tabs->tab($tab);
		}
		$form->addField($tabs);
		
		# Buttons
		$form->addFields(array(
			GDO_Submit::make(),
			GDO_AntiCSRF::make(),
		));
		
		# Dynamic buttons
		if ($this->news)
		{
			$form->addFields(array(
				GDO_Submit::make('preview'),
			));
			
			if (!$this->news->isVisible())
			{
				$form->addField(GDO_Submit::make('visible'));
			}
			else
			{
				$form->addField(GDO_Submit::make('invisible'));
				if (!$this->news->isSent())
				{
					$form->addField(GDO_Submit::make('send'));
				}
			}
			
			$form->addField(GDO_NewsStatus::make('status'));
			
			$form->withGDOValuesFrom($this->news);
		}
	}
	
	public function formValidated(GDO_Form $form)
	{
		# Update news
		$news = $this->news ? $this->news : News::blank();
		$news->setVars($form->getField('news_category')->getGDOData());
		$news->replace();

		# Update texts
		foreach ($_POST['form']['iso'] as $iso => $data)
		{
			$title = trim($data['newstext_title']);
			$message = trim($data['newstext_message']);
			if ($title || $message)
			{
				$text = NewsText::blank(array(
					'newstext_news' => $news->getID(),
					'newstext_lang' => $iso,
					'newstext_title' => $title,
					'newstext_message' => $message,
				))->replace();
			}
		}
		
		if ($this->news)
		{
			$this->news->tempUnset('newstexts');
			$this->news->recache();
			return $this->message('msg_news_edited')->add($this->renderPage());
		}
		
		$hrefEdit = href('News', 'Write', '&id='.$news->getID());
		return $this->message('msg_news_created')->add(Website::redirectMessage($hrefEdit));
	}
	
	public function onSubmit_visible(GDO_Form $form)
	{
		$this->news->saveVar('news_visible', '1');
		$this->form = null;
		return $this->message('msg_news_visible')->add($this->renderForm());
	}
	
	public function onSubmit_invisible(GDO_Form $form)
	{
		$this->news->saveVar('news_visible', '0');
		$this->form = null;
		return $this->message('msg_news_invisible')->add($this->renderForm());
	}
	
	############
	### Mail ###
	############
	public function onSubmit_preview(GDO_Form $form)
	{
	}
	
	public function onSubmit_send(GDO_Form $form)
	{
		$this->news->saveVar('news_send', Time::getDate());
		return $this->message('msg_news_queue')->add($this->renderForm());
		
	}
	
}
