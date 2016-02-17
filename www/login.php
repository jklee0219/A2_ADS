<?php include_once $_SERVER['DOCUMENT_ROOT'].'/comm/top.php'; ?>
<!DOCTYPE html>
<html lang='ko'>
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/comm/head.php'; ?>
<link rel="stylesheet" href="/css/login.css">
<script src="/js/login.js"></script>
</head>
<body>
	<div class="alert alert-success loginFrm_wrap" role="alert">
		<form name="loginFrm" action="/comm/proc.php" method="post" onsubmit="return validateForm()" target="hiddenFrm">
		<input type="password" name="pw" maxlength="20" class="form-control" id="pwd" placeholder="비밀번호">
		<button type="submit" id="login_btn" class="btn btn-primary">로그인</button>
		<input type="hidden" name="type" value="login">
    	</form>
    </div>
    <iframe name="hiddenFrm"></iframe>
</body>
</html>