<?php 
$ddinfo     = mysqli_query($dbconn, "select company from TB_INFO");
$ddinfo     = mysqli_fetch_array($ddinfo);

$COMPANY_NAME = $ddinfo[0];
$TITLE_TEXT   = $COMPANY_NAME." 광고 관리 페이지";