<?php
 
function get_template($temp_fn, $str_arr="", $body_cut=false){
	/*
	 * $temp_fn - 템플릿 경로
	 * $str_arr - 치환문자열 배열
	 * $body_cut - <body>~</body> 태그내의 소스만 가져옴
	 */
	$return_template = $str;
	$temp_fn_fp = $_SERVER['DOCUMENT_ROOT']."../template/".$temp_fn;
	if(file_exists($temp_fn_fp)){
		$return_template = file_get_contents($temp_fn_fp);
		$return_template = preg_replace('/\r\n|\r|\n/','',$return_template); //개행제거
		$return_template = str_replace("class=\"mbox", "class=\"mbox2", $return_template);
		if($str_arr){
			foreach ($str_arr as $k => $v){
				$return_template = str_replace($k, $v, $return_template);
			}
		}
		if($body_cut && preg_match_all('@<body>(.*?)</body>@i', $return_template, $matches)){
			$return_template = $matches[1][0];
		}
	}
	
	echo $return_template;
	if(!$body_cut) exit();
}

function pLocationHref($url,$msg=""){
	echo "<script>";
	if($msg) echo "alert('".$msg."');"; 
	echo "parent.location.href = '".$url."'";
	echo "</script>";
	exit();
}

//쿼리를 배열로 리턴 해주는 함수
function getQueryResult($query) {
	global $dbconn;
	
	$returnResultArray = array ();

	if ($dbconn && $query) {
		$result = mysqli_query($dbconn,$query);
		if ($result) {
			if(mysqli_num_rows($result) > 0){
				while ($qry_result_row = mysqli_fetch_array ($result)) {
					$rowArray = array ();
					foreach ($qry_result_row as $_key => $_val) {
						if (strlen($_key) > 1) {
							$colurm_name = $_key;
							$rowArray[$colurm_name] = array ();
							$rowArray[$colurm_name] = $_val;
						}
					}

					array_push($returnResultArray,$rowArray);
				}
			}
			mysqli_free_result($result);
		}
	}
	return $returnResultArray;
}

function getQueryCount($query) {
	global $dbconn;
	
	$returnResultValue = 0;

	if ($dbconn && stripos($query,"count(*)") !== false) {
		$result = mysqli_query($dbconn,$query);
		$returnResultValue = mysqli_fetch_row($result)[0];

		mysqli_free_result($result);
	}
	return $returnResultValue;
}