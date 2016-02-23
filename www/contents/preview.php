<?php
$curl = curl_init();

curl_setopt ($curl, CURLOPT_URL, 'http://www.asiatoday.co.kr/view.php?key=20160223010014313');
curl_setopt ($curl, CURLOPT_HEADER, 0);
curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12');
curl_setopt ($curl, CURLOPT_TIMEOUT, 10);

$html = curl_exec($curl);

curl_close($curl);

$fp = fopen($TEMP_FOLDER.'preview.html', 'a');
fwrite($fp, $html);
fclose($fp);
?>
<div class="content_wrap">
	미리보기	
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/form/ads_form.php';?>