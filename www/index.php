<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/comm/top.php';
$contents_name = filter_input(INPUT_GET, 'cn');
$contents_name = !$contents_name ? "adverlist" : $contents_name; 
?>
<!DOCTYPE html>
<html lang='ko'>
<head>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/comm/head.php'; ?>
<link rel="stylesheet" href="/css/<?=$contents_name?>.css">
<script src="/js/<?=$contents_name?>.js"></script>
</head>
<body>
	<header><?php include_once $_SERVER['DOCUMENT_ROOT'].'/comm/nav.php'; ?></header>
	<section><?php include_once $_SERVER['DOCUMENT_ROOT'].'/contents/'.$contents_name.'.php'; ?></section>
	<footer class="linear"><?php include_once $_SERVER['DOCUMENT_ROOT'].'/comm/footer.php'; ?></footer>
</body>
</html>