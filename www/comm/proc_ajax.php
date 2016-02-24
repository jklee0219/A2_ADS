<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/top.php';

$type = addslashes($_REQUEST['type']);
$xml  = "";

switch ($type){
	case "category_list" :
		$qr = getQueryResult("SELECT seq,title FROM TB_CATEGORY WHERE delyn = 'N' ORDER BY seq DESC");
		$xml  = "<root>";
		foreach ($qr as $k => $v){
			$xml .= "<item>";
			$xml .= "	<seq>".$v['seq']."</seq>";
			$xml .= "	<title><![CDATA[".$v['title']."]]></title>";
			$xml .= "</item>";
		}
		$xml .= "</root>";
		break;
		
	case "category_insert" :
		$title = filter_input(INPUT_POST, 'title');
		$exec  = false;
	
		if($title){
			$stmt = mysqli_prepare($dbconn, "INSERT INTO TB_CATEGORY (title) VALUES (?)");
			$bind = mysqli_stmt_bind_param($stmt, "s", $title);
			$exec = mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;

	case "category_update" :
		$seq    = filter_input(INPUT_POST, 'seq');
		$title  = filter_input(INPUT_POST, 'title');
		$exec   = false;
	
		if($title && $seq){
			$stmt = mysqli_prepare($dbconn, "UPDATE TB_CATEGORY SET TITLE = ?, udate = CURRENT_TIMESTAMP WHERE seq = ?");
			$bind = mysqli_stmt_bind_param($stmt, "si", $title, $seq);
			$exec = mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
		
	case "category_delete" :
		$seq    = filter_input(INPUT_POST, 'seq');
		$exec   = false;
	
		if($seq){
			$stmt = mysqli_prepare($dbconn, "SELECT COUNT(*) cnt FROM TB_ADS WHERE category = ? AND delyn = 'N'");
			$stmt->bind_param("i", $seq);
			$stmt->execute();
			$stmt->bind_result($cnt);
			$stmt->fetch();
			$stmt->close();
			$exec = "REJECT";
			if($cnt == 0){
				$stmt = mysqli_prepare($dbconn, "UPDATE TB_CATEGORY SET delyn = 'Y', ddate = CURRENT_TIMESTAMP WHERE seq = ?");
				$bind = mysqli_stmt_bind_param($stmt, "i", $seq);
				$exec = mysqli_stmt_execute($stmt);
				$exec = $exec ? "SUCCESS" : "FAIL";
				mysqli_stmt_close($stmt);
			}
		}
	
		$xml  = "<root>";
		$xml .= "<result>".$exec."</result>";
		$xml .= "</root>";
		break;
		
	case "adform_insert" :
		$grp_useyn    = filter_input(INPUT_POST, 'grp_useyn');
		$grp_category = filter_input(INPUT_POST, 'grp_category');
		$grp_title    = filter_input(INPUT_POST, 'grp_title');
		$exec  = false;
	
		if($grp_useyn && $grp_category && $grp_title){
			$stmt = mysqli_prepare($dbconn, "INSERT INTO TB_ADS (useyn,category,title) VALUES (?, ?, ?)");
			$bind = mysqli_stmt_bind_param($stmt, "sis", $grp_useyn, $grp_category, $grp_title);
			$exec = mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "<insert_id>".$dbconn->insert_id."</insert_id>";
		$xml .= "</root>";
		break;
		

	case "adform_update" :
		$grp_seq      = filter_input(INPUT_POST, 'grp_seq');
		$grp_useyn    = filter_input(INPUT_POST, 'grp_useyn');
		$grp_category = filter_input(INPUT_POST, 'grp_category');
		$grp_title    = filter_input(INPUT_POST, 'grp_title');
		$exec  = false;
	
		if($grp_useyn && $grp_category && $grp_title){
			$stmt = mysqli_prepare($dbconn, "UPDATE TB_ADS SET useyn = ?, category = ?, title = ?, udate = CURRENT_TIMESTAMP WHERE seq = ?");
			$bind = mysqli_stmt_bind_param($stmt, "sisi", $grp_useyn, $grp_category, $grp_title, $grp_seq);
			$exec = mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
		}
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
	
	case "ads_list" :
		$seq = filter_input(INPUT_POST, 'seq');
		
		$qr = getQueryResult("SELECT useyn,category,title FROM TB_ADS WHERE delyn = 'N' AND seq = '".$seq."' limit 1");
		$grp_useyn    = $qr[0]['useyn'];
		$grp_category = $qr[0]['category'];
		$grp_title    = $qr[0]['title'];
		
		$qr = getQueryResult("SELECT seq,useyn,ratio,title,sdate,edate,width,height,script FROM TB_SCRIPTS WHERE delyn = 'N' AND ref = '".$seq."'");
		
		$xml   = "<root>";
		$xml  .= "<grp_useyn>".$grp_useyn."</grp_useyn>";
		$xml  .= "<grp_category>".$grp_category."</grp_category>";
		$xml  .= "<grp_title>".$grp_title."</grp_title>";
		foreach ($qr as $k => $v){
			$xml .= "<item>";
			$xml .= "	<seq>".$v['seq']."</seq>";
			$xml .= "	<useyn><![CDATA[".$v['useyn']."]]></useyn>";
			$xml .= "	<ratio><![CDATA[".$v['ratio']."]]></ratio>";
			$xml .= "	<title><![CDATA[".$v['title']."]]></title>";
			$xml .= "	<sdate><![CDATA[".$v['sdate']."]]></sdate>";
			$xml .= "	<edate><![CDATA[".$v['edate']."]]></edate>";
			$xml .= "	<width><![CDATA[".$v['width']."]]></width>";
			$xml .= "	<height><![CDATA[".$v['height']."]]></height>";
			$xml .= "	<script><![CDATA[".$v['script']."]]></script>";
			$xml .= "</item>";
		}
		$xml .= "</root>";
		break;
			
	case "ads_insert" :
		$ads_id       = filter_input(INPUT_POST, 'ads_id');
		$ad_title     = filter_input(INPUT_POST, 'ad_title');
		$ad_useyn     = filter_input(INPUT_POST, 'ad_useyn');
		$ad_ratio     = filter_input(INPUT_POST, 'ad_ratio');
		$ad_sdate     = filter_input(INPUT_POST, 'ad_sdate');
		$ad_edate     = filter_input(INPUT_POST, 'ad_edate');
		$ad_width     = filter_input(INPUT_POST, 'ad_width');
		$ad_height    = filter_input(INPUT_POST, 'ad_height');
		$ad_script    = filter_input(INPUT_POST, 'ad_script');
		//$ad_script    = mysql_real_escape_string($ad_script);
		$ad_script    = urldecode($ad_script);
		$ad_script    = html_entity_decode($ad_script);
		$exec         = false;
	
		$stmt = mysqli_prepare($dbconn, "INSERT INTO TB_SCRIPTS (ref,title,useyn,ratio,sdate,edate,width,height,script) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$bind = mysqli_stmt_bind_param($stmt, "ississiis", $ads_id, $ad_title, $ad_useyn, $ad_ratio, $ad_sdate, $ad_edate, $ad_width, $ad_height, $ad_script);
		$exec = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
			
	case "ads_update" :
		$ads_id       = filter_input(INPUT_POST, 'ads_id');
		$ad_seq       = filter_input(INPUT_POST, 'ad_seq');
		$ad_title     = filter_input(INPUT_POST, 'ad_title');
		$ad_useyn     = filter_input(INPUT_POST, 'ad_useyn');
		$ad_ratio     = filter_input(INPUT_POST, 'ad_ratio');
		$ad_sdate     = filter_input(INPUT_POST, 'ad_sdate');
		$ad_edate     = filter_input(INPUT_POST, 'ad_edate');
		$ad_width     = filter_input(INPUT_POST, 'ad_width');
		$ad_height    = filter_input(INPUT_POST, 'ad_height');
		$ad_script    = filter_input(INPUT_POST, 'ad_script');
		//$ad_script    = mysql_real_escape_string($ad_script);
		$ad_script    = urldecode($ad_script);
		$ad_script    = html_entity_decode($ad_script);
		$exec         = false;
		
		if($ad_seq){
			$stmt = mysqli_prepare($dbconn, "UPDATE TB_SCRIPTS SET title = ?, useyn = ?, ratio = ?, sdate = ?, edate = ?, width = ?, height = ?, script = ?, udate = CURRENT_TIMESTAMP WHERE seq = ?");
			$bind = mysqli_stmt_bind_param($stmt, "ssissiisi", $ad_title, $ad_useyn, $ad_ratio, $ad_sdate, $ad_edate, $ad_width, $ad_height, $ad_script, $ad_seq);
		}else{
			$stmt = mysqli_prepare($dbconn, "INSERT INTO TB_SCRIPTS (ref,title,useyn,ratio,sdate,edate,width,height,script) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$bind = mysqli_stmt_bind_param($stmt, "ississiis", $ads_id, $ad_title, $ad_useyn, $ad_ratio, $ad_sdate, $ad_edate, $ad_width, $ad_height, $ad_script);
		}
		$exec = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
		
	case "ad_delete" :
		$ad_seq = filter_input(INPUT_POST, 'ad_seq');
		$exec   = false;
	
		$stmt = mysqli_prepare($dbconn, "UPDATE TB_SCRIPTS SET delyn = 'Y', ddate = CURRENT_TIMESTAMP WHERE seq = ?");
		$bind = mysqli_stmt_bind_param($stmt, "i", $ad_seq);
		$exec = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
		
	case "all_delete" :
		$ads_seq = filter_input(INPUT_POST, 'ads_seq');
		$exec    = false;

		$stmt = mysqli_prepare($dbconn, "UPDATE TB_SCRIPTS SET delyn = 'Y', ddate = CURRENT_TIMESTAMP WHERE ref = ?");
		$bind = mysqli_stmt_bind_param($stmt, "i", $ads_seq);
		$exec = mysqli_stmt_execute($stmt);
		
		$stmt = mysqli_prepare($dbconn, "UPDATE TB_ADS SET delyn = 'Y', ddate = CURRENT_TIMESTAMP WHERE seq = ?");
		$bind = mysqli_stmt_bind_param($stmt, "i", $ads_seq);
		$exec = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		
		$xml  = "<root>";
		$xml .= "<result>".($exec ? "SUCCESS" : "FAIL")."</result>";
		$xml .= "</root>";
		break;
		
}

if($dbconn) mysqli_close($dbconn);

@header('Content-Type: text/xml; charset=UTF-8');
@header('Pragma: no-cache');
@header('Cache-Control: no-cache,must-revalidate');

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo $xml;