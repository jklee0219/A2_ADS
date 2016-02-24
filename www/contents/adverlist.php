<?php
$search_keyword = filter_input(INPUT_GET, 'sk');
$where_str      = $search_keyword ? " and A.`title` like '%".$search_keyword."%' " : "";   
$scale          = $_COOKIE['adverlist_pageselect'];
$page           = filter_input(INPUT_GET, 'p') ? filter_input(INPUT_GET, 'p') : 1;

$listqry  = " SELECT 
				A.seq,
				(SELECT title FROM TB_CATEGORY B WHERE B.seq = A.category AND B.delyn = 'N') AS category_name,
				A.title,
				(SELECT COUNT(*) FROM TB_SCRIPTS C WHERE C.ref = A.seq AND now() between C.sdate and C.edate AND C.useyn = 'Y' AND C.delyn = 'N') AS ads_use_cnt,
			    (SELECT COUNT(*) FROM TB_SCRIPTS C WHERE C.ref = A.seq AND C.delyn = 'N') AS ads_tot_cnt,  
				A.useyn,
				A.wdate
			 FROM TB_ADS AS A
		     WHERE A.delyn = 'N' ".$where_str."
			 ORDER BY A.seq DESC";
$cntqry   = " SELECT COUNT(*) FROM TB_ADS A WHERE A.delyn = 'N' ".$where_str;

$adscount     = getQueryCount($cntqry);

$limit    = "";

$total_record = $adscount;
$param        = $search_keyword ? '&sk='.$search_keyword : "";
if($scale != "remove"){
	$total_page   = ceil($total_record/$scale);
	$first        = $scale * ($page - 1);
	$no           = $total_record - $first + 1;
	$total_block  = ceil($total_page / 5);
	$block        = ceil($page / 5);
	$first_page   = ($block - 1) * 5;
	$last_page    = $total_block <= $block ? $total_page : $block * 5;
	$prev         = $first_page;
	$next         = $last_page + 1;
	$go_page      = $first_page + 1;
}else{
	$no = $total_record + 1;
}
$limit        = $scale != "remove" ? ' limit '.$first.', '.$scale : "";

$adslist      = getQueryResult($listqry.$limit);
?>
<div class="content_wrap">
	<nav id="list_nav">
	  	<select class="form-control" name="pageselect">
		    <option <?=$scale==15 ? "selected='selected'" : ""?> value="15">15</option>
		    <option <?=$scale==50 ? "selected='selected'" : ""?> value="50">50</option>
		    <option <?=$scale==100 ? "selected='selected'" : ""?> value="100">100</option>
		    <option <?=$scale=="remove" ? "selected='selected'" : ""?> value="remove">∞</option>
		</select>
		<?php if($scale != "remove" && $scale < $total_record){ ?>
		<ul class="pagination pagination-sm">
	    	<?php if ($block > 1) {?><li><a href="/index.php?cn=adverlist&p=<?=$go_page.$param?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li><?php }?>
	    	<?php for ($go_page; $go_page <= $last_page; $go_page++) {
				if ($page == $go_page) {
					echo "<li class='active'><a>".$go_page."</a></li>";
				} else {
					echo "<li><a href='/index.php?cn=adverlist&p=".$go_page.$param."'>".$go_page."</a></li>";
				}
			}?>
	    	<?php if ($block < $total_block) {?><li><a href="/index.php?cn=adverlist&p=<?=$go_page.$param?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li><?php }?>
	  	</ul>
	  	<?php } ?>
	  	<div class="fr">
	  		<form action="/index.php" method="get" class="form-horizontal" role="form">
	  			<input type="hidden" name="cn" value="adverlist">
			  	<input type="text" class="fl ml5 form-control" name="sk" placeholder="그룹명 검색" value="<?=$search_keyword?>">
			  	<input type="submit" class="fl ml5 btn btn-primary btn-sm" value="검색">
			  	<button type="button" id="make_ads" class="fl ml5 btn btn-success btn-sm" data-toggle="modal" data-target="#ads_form">광고그룹생성</button>
		  	</form>
		</div>
	</nav>
	
	<table id="ql" class="table table-striped table-bordered table-hover" cellspacing="0">
        <thead>
            <tr class="linear">
            	<th>번호</th>
                <th>카테고리</th>
                <th>광고그룹명</th>
                <th>광고수</th>
                <th>광고상태</th>
                <th>등록일</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
        	foreach($adslist as $k => $v){
				$use_str = ""; //광고없음,중지,사용중,광고소진
				$use_str = $v['useyn'] == "Y" ? "사용중" : $use_str;
				$use_str = $v['ads_tot_cnt'] == 0 ? "광고없음" : $use_str;
				$use_str = ($v['ads_tot_cnt'] > 0 && $v['ads_use_cnt'] == 0) ? "광고소진" : $use_str;
				$use_str = $v['useyn'] == "N" ? "사용중지" : $use_str;
			?>
            <tr class='active<?=($use_str=="사용중") ? " success" : ""?>' data-toggle="modal" data-target="#ads_form" onclick="adsUpdateForm('<?=$v['seq']?>')">
            	<td><?=--$no?></td>
                <td><?=$v['category_name']?></td>
                <td><?=$v['title']?></td>
                <td><?=$v['ads_use_cnt']?>&nbsp;/&nbsp;<?=$v['ads_tot_cnt']?></td>
                <td><?=$use_str?></td>
                <td><?=$v['wdate']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/form/ads_form.php';?>