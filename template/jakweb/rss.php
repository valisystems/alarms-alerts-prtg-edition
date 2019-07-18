<?php header("Content-Type: text/xml; charset=utf-8");?>
<rss version="2.0">
  <channel>
  <title><?php echo $JAK_RSS_TITLE;?></title>
      <link><?php echo BASE_URL;?></link>
      <description><![CDATA[<?php echo $JAK_RSS_DESCRIPTION;?>]]></description>
      <language><?php echo $site_language;?></language>
      <pubDate><?php echo $JAK_RSS_DATE;?></pubDate>
      <generator><?php echo BASE_URL;?></generator>
 <?php if (isset($JAK_GET_RSS_ITEM) && is_array($JAK_GET_RSS_ITEM)) foreach($JAK_GET_RSS_ITEM as $rss) { ?>
 	<item>
       <title><?php echo $rss["title"];?></title>
       <link><?php echo $rss["link"];?></link>
       <description><![CDATA[<?php echo $rss["description"];?>]]></description>
       <pubDate><?php echo $rss["created"];?></pubDate>
 	</item>
 <?php } ?>
  </channel>
</rss>