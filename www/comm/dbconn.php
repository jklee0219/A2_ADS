<?php
$dbconn = mysqli_connect(CONNECT_DB_HOST, CONNECT_DB_ID, CONNECT_DB_PW, CONNECT_DB_NAME);
mysqli_set_charset($dbconn, 'utf8');