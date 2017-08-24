<?php
use GDO\News\RSS;
use GDO\News\RSSItem;
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <atom:link href="<?= html($title_link) ?>" rel="self" type="application/rss+xml" />
    <title><?= html($feed_title); ?></title>
    <link><?= html($title_link); ?></link>
    <description><?= html($feed_description); ?></description>
    <language><?= $language; ?></language>
    <lastBuildDate><?= $build_date; ?></lastBuildDate>
    <pubDate><?= $pub_date; ?></pubDate>
    <image>
      <title><?= html($feed_title); ?></title>
      <url><?= html($image_url); ?></url>
      <link><?= html($title_link); ?></link>
      <width><?= $image_width; ?></width>
      <height><?= $image_height; ?></height>
    </image>
<?php foreach ($items as $item) : $item instanceof RSSItem; ?>
    <item>
      <title><?= RSS::displayCData($item->getRSSTitle()); ?></title>
<?php if ($link =  $item->getRSSLink()) echo sprintf('<link>%s</link>', html($link)).PHP_EOL; ?>
      <description><?= RSS::displayCData($item->getRSSDescription()); ?></description>
<?php if ($guid =  $item->getRSSGUID()) echo sprintf('<guid>%s</guid>', $guid).PHP_EOL; ?>
      <pubDate><?= RSS::displayDate($item->getRSSPubDate()); ?></pubDate>
    </item>
<?php endforeach; ?>
  </channel>
</rss>
