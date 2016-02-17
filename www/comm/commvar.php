<?php
session_start();
$PAGENAME = basename($_SERVER['PHP_SELF'], '.php');
$LOGIN_SESSION_VALUE = "login_ok";