<?php
include_once $_SERVER['DOCUMENT_ROOT'].'../config.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/commvar.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/messages.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/func.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/dbconn.php';

if(!in_array($PAGENAME,array('proc'))){
	include_once $_SERVER['DOCUMENT_ROOT'].'/comm/dbchk.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/comm/ddbinfo.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/comm/loginchk.php';
}