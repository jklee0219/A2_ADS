<?php
if($_SESSION['ADM_LOGIN'] != $LOGIN_SESSION_VALUE && $PAGENAME != "login") header('Location: /login.php');
if($_SESSION['ADM_LOGIN'] == $LOGIN_SESSION_VALUE && $PAGENAME == "login") header('Location: /');