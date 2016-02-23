<?php
session_start();
$LOGIN_SESSION_VALUE = "login_ok";
$PAGENAME            = basename($_SERVER['PHP_SELF'], '.php');
$TEMP_FOLDER         = $_SERVER['DOCUMENT_ROOT'].'/../temp/';