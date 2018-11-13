<?php
$rss= new DOMDocument();
$rss->load("http://kotaku.com/vip.xml");
$rss_list = $rss->getElementsByTagName("item");
foreach ($rss_list as $key => $value) {
    echo $value->textContent;
}
?>