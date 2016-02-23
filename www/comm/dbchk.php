<?php
$TB_INFO    = "CREATE TABLE `TB_INFO` (
               `company` varchar(200) NOT NULL DEFAULT '' COMMENT '업체명',
			   `password` varchar(200) NOT NULL DEFAULT '' COMMENT '비밀번호',
   			   `wdate` datetime NOT NULL DEFAULT NOW() COMMENT '등록일자',
   			   PRIMARY KEY (`company`)
			   ) ENGINE=MYISAM CHARSET=utf8 COMMENT='업체정보'";

$TB_ADS     = "CREATE TABLE `TB_ADS` (
       		   `seq` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유번호',
   			   `category` int(8) unsigned COMMENT 'TB_CATEGORY SEQ',
               `title` varchar(500) NOT NULL DEFAULT '' COMMENT '광고그룹명',
   	           `useyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '사용여부',
   	           `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제여부',
   			   `wdate` datetime NOT NULL DEFAULT NOW() COMMENT '등록일자',
   			   `udate` datetime DEFAULT NULL COMMENT '수정일자',
   			   `ddate` datetime DEFAULT NULL COMMENT '삭제일자',
   			   PRIMARY KEY (`seq`),
			   FOREIGN KEY (`category`) REFERENCES `TB_CATEGORY` (`seq`),
			   FULLTEXT TITLE_FIDX (`title`)
			   ) ENGINE=MYISAM CHARSET=utf8 COMMENT='광고그룹 관리'";

$TB_SCRIPTS = "CREATE TABLE `TB_SCRIPTS` (
       		   `seq` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유번호',
			   `ref` int(8) unsigned COMMENT 'TB_ADS SEQ',
			   `title` varchar(500) NOT NULL DEFAULT '' COMMENT '광고명',
               `script` text COMMENT '광고스크립트',
               `width` int(1) unsigned DEFAULT 0 COMMENT '광고가로사이즈',
   			   `height` int(1) unsigned DEFAULT 0 COMMENT '광고세로사이즈',
   			   `sdate` datetime DEFAULT NULL COMMENT '광고시작일',
   			   `edate` datetime DEFAULT NULL COMMENT '광고종료일',
   	           `ratio` int(1) unsigned DEFAULT 0 COMMENT '광고비율',
   	           `useyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '사용여부',
   	           `delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제여부',
   			   `wdate` datetime NOT NULL DEFAULT NOW() COMMENT '등록일자',
   			   `udate` datetime DEFAULT NULL COMMENT '수정일자',
   			   `ddate` datetime DEFAULT NULL COMMENT '삭제일자',
   			   PRIMARY KEY (`seq`),
			   FOREIGN KEY (`ref`) REFERENCES `TB_ADS` (`seq`),
			   FULLTEXT TITLE_FIDX (`title`),
			   FULLTEXT SCRIPT_FIDX (`script`)
			   ) ENGINE=MYISAM CHARSET=utf8 COMMENT='광고스크립트 관리'";

$TB_CATEGORY = "CREATE TABLE `TB_CATEGORY` (
				`seq` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '고유번호',
				`ref` int(8) unsigned NOT NULL DEFAULT '0' COMMENT '부모코드',
				`title` varchar(100) NOT NULL DEFAULT '' COMMENT '카테고리명',
				`useyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '사용여부',
				`delyn` enum('Y','N') NOT NULL DEFAULT 'N' COMMENT '삭제여부',
				`wdate` datetime DEFAULT NOW() COMMENT '등록일자',
				`udate` datetime DEFAULT NULL COMMENT '수정일자',
				`ddate` datetime DEFAULT NULL COMMENT '삭제일자',
				PRIMARY KEY (`seq`)
				) ENGINE=MYISAM CHARSET=utf8 COMMENT='카테고리 관리'";

if(!$dbconn){ get_template("error.html",array("[MESSAGE]" => $M001)); }

$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".CONNECT_DB_NAME."' and table_name = 'TB_INFO' ");
if(mysqli_fetch_row($res)[0] == 0){ mysqli_query($dbconn, $TB_INFO); }

$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM TB_INFO ");
if(mysqli_fetch_row($res)[0] != 1){ get_template("infoform.html",array("[COMPANY_NAME]" => "")); }

$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".CONNECT_DB_NAME."' and table_name = 'TB_CATEGORY' ");
if(mysqli_fetch_row($res)[0] == 0){ mysqli_query($dbconn, $TB_CATEGORY); }

$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".CONNECT_DB_NAME."' and table_name = 'TB_ADS' ");
if(mysqli_fetch_row($res)[0] == 0){ mysqli_query($dbconn, $TB_ADS); }

$res = mysqli_query($dbconn, " SELECT COUNT(*) AS count FROM information_schema.tables WHERE table_schema = '".CONNECT_DB_NAME."' and table_name = 'TB_SCRIPTS' ");
if(mysqli_fetch_row($res)[0] == 0){ mysqli_query($dbconn, $TB_SCRIPTS); }

//web 관리 temp 폴더 생성
if(!file_exists($TEMP_FOLDER)){
	if(!mkdir($TEMP_FOLDER, 0777, true)){ get_template("error.html",array("[MESSAGE]" => $M002)); }
}