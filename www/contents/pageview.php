<?php
$curl = curl_init();

curl_setopt ($curl, CURLOPT_URL, 'http://www.asiatoday.co.kr/view.php?key=20160224010014767');
curl_setopt ($curl, CURLOPT_URL, 'http://www.naver.com/');
curl_setopt ($curl, CURLOPT_HEADER, 0);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12');
curl_setopt ($curl, CURLOPT_TIMEOUT, 10);

$html = curl_exec($curl);


$html = str_ireplace("src='/", "src='http://www.naver.com/", $html);
$html = str_ireplace("src=\"/", "src=\"http://www.naver.com/", $html);
$html = str_ireplace("href='/", "href='http://www.naver.com/", $html);
$html = str_ireplace("href=\"/", "href=\"http://www.naver.com/", $html);
$html = str_ireplace("</head>", "<style>.aside_google_304{border:5px solid red}</style></head>", $html);
?>

<?php 
curl_close($curl);

$fp = fopen($TEMP_FOLDER.'pageview.html', 'w');
fwrite($fp, $html);
fclose($fp);
?> 
<div class="content_wrap">
	<iframe id="iframe" frameborder=0 src="/temp/pageview.html" style="background-color:#FFF" width="100%" height="700"></iframe>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/form/ads_form.php';?>