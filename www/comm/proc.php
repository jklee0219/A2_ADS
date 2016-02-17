<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/top.php';

$type = addslashes($_REQUEST['type']);

switch ($type){
	case "infoform" :
		$company  = filter_input(INPUT_POST, 'company');
		$password = filter_input(INPUT_POST, 'password');
		
		mysqli_query($dbconn, "DELETE FROM TB_INFO"); //로우는 항상 1개를 유지
		
		$stmt = mysqli_prepare($dbconn, "INSERT INTO TB_INFO (company, `password`) VALUES (?, password(?))");
		$bind = mysqli_stmt_bind_param($stmt, "ss", $company, $password);
		$exec = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
		
		pLocationHref("/");
		break;
		
	case "login" :
		$password = filter_input(INPUT_POST, 'pw');
		$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM TB_INFO WHERE `password` = password('".$password."') ");
		if(mysqli_fetch_row($res)[0] == 1){ 
			$_SESSION['ADM_LOGIN'] = $LOGIN_SESSION_VALUE;
			pLocationHref("/");
		}else{
			pLocationHref("/","비밀번호가 잘못 되었습니다.");
		}
		break; 
		
	case "logout" :
		session_destroy();
		pLocationHref("/");
		break;
}

if($dbconn) mysqli_close($dbconn);