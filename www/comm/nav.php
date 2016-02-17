<nav class="navbar navbar-inverse navbar-fixed-top linear">
	<div class="container">
  		<div class="navbar-header">
    		<a class="navbar-brand" href="/"><?=$COMPANY_NAME?></a>
  		</div>
  		<div id="navbar" class="navbar-collapse collapse">
        	<ul class="nav navbar-nav">
	            <li <?=$contents_name=="adverlist" ? 'class="active"' : ''?>><a href="/index.php?cn=adverlist"><i class="glyphicon glyphicon-wrench"></i><span>광고관리</span></a></li>
	            <li <?=$contents_name=="preview" ? 'class="active"' : ''?>><a href="/index.php?cn=preview"><i class="glyphicon glyphicon-file"></i><span>미리보기</span></a></li>
	            <li <?=$contents_name=="svrlist" ? 'class="active"' : ''?>><a href="/index.php?cn=svrlist"><i class="glyphicon glyphicon-hdd"></i><span>서버관리</span></a></li>
	            <li <?=$contents_name=="statistics" ? 'class="active"' : ''?>><a href="/index.php?cn=statistics"><i class="glyphicon glyphicon-stats"></i><span>광고별통계</span></a></li>
	            <li <?=$contents_name=="infoform" ? 'class="active"' : ''?>><a href="/index.php?cn=infoform"><i class="glyphicon glyphicon-cog"></i><span>관리정보수정</span></a></li>
	            <li id="logout_btn"><a href="javascript:logout()"><i class="glyphicon glyphicon-log-out"></i><span>로그아웃</span></a></li>
        	</ul>
  		</div>
	</div>
</nav>