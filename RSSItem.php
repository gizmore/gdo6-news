<?php
namespace GDO\News;
interface RSSItem
{
	public function getRSSTitle();
	public function getRSSDescription();
	public function getRSSLink();
	public function getRSSGUID();
	public function getRSSPubDate();
}
