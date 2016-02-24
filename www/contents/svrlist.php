<?php
$listqry  = " SELECT 
				A.seq,
				A.ip,
				A.port,
				A.id,
				A.pw,
				A.title,  
				A.useyn,
				A.wdate
			 FROM TB_SVRLIST AS A
			 WHERE delyn = 'N'
		     ORDER BY A.seq";

$svrlist   = getQueryResult($listqry);
?>
<div class="content_wrap">
	<nav id="list_nav">
	  	<div class="fr">
	  		<form action="/index.php" method="get" class="form-horizontal" role="form">
			  	<button type="button" id="make_svrlist" class="fl ml5 btn btn-success btn-sm" data-toggle="modal" data-target="#svr_form" onclick="formInit()">서버 추가</button>
		  	</form>
		</div>
	</nav>
	
	<table id="ql" class="table table-striped table-bordered table-hover" cellspacing="0">
        <thead>
            <tr class="linear">
            	<th>번호</th>
                <th>상태</th>
                <th>서버명</th>
                <th>HOST IP</th>
                <th>PORT</th>
                <th>FTP ID</th>
                <th>FTP PW</th>
                <th>등록일</th>
            </tr>
        </thead>
        <tbody>
        	<?php 
        	$no = 1;
        	foreach($svrlist as $k => $v){
				$use_str = ""; //광고없음,광고소진
				$use_str = $v['useyn'] == "Y" ? "사용중" : $use_str;
				$use_str = $v['useyn'] == "N" ? "사용중지" : $use_str;
			?>
            <tr id="row_<?=$v['seq']?>" class='active<?=($use_str=="사용중") ? " success" : ""?>' data-toggle="modal" data-target="#svr_form" onclick="svrUpdateForm($(this))">
            	<td class="seq" value="<?=$v['seq']?>"><?=$no++?></td>
                <td class="useyn" value="<?=$v['useyn']?>"><strong><?=$use_str?></strong></td>
                <td class="title"><?=$v['title']?></td>
                <td class="ip"><?=$v['ip']?></td>
                <td class="port"><?=$v['port']?></td>
                <td class="id"><?=$v['id']?></td>
                <td class="pw"><?=$v['pw']?></td>
                <td><?=$v['wdate']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- 서버등록폼 -->
<div id="svr_form" class="modal fade" role="dialog">
	<div class="modal-dialog">
		
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">서버 등록</h4>
		    </div>
		    <div class="modal-body">
		    	<form class="form-horizontal" role="form">
					<input type="hidden" id="svr_seq" value="">
		    		<div class="form-group">
				  		<label class="col-sm-3 control-label" for="grp_useyn">서버사용여부</label>
				  		<div class="col-sm-3">
					    	<select id="svr_useyn" class="form-control input-sm">
							    <option value="Y">사용</option>
							    <option value="N">중지</option>
							</select>
						</div>
				  	</div>
				  	<div class="form-group">
				  		<label class="col-sm-3 control-label" for="grp_category">서버명</label>
				  		<div class="col-sm-7">
					    <input class="form-control input-sm" maxlength="100" id="svr_title" type="text" placeholder="서버명" required>
						</div>
				  	</div>
		    		<div class="form-group">
				  		<label class="col-sm-3 control-label" for="grp_category">HOST IP</label>
				  		<div class="col-sm-7">
					    <input class="form-control input-sm" maxlength="30" id="svr_ip" type="text" placeholder="HOST IP" required>
						</div>
				  	</div>
				  	<div class="form-group">
				  		<label class="col-sm-3 control-label" for="grp_category">PORT</label>
				  		<div class="col-sm-7">
					    <input class="form-control input-sm" maxlength="10" id="svr_port" type="text" placeholder="PORT" value="21" required>
						</div>
				  	</div>
				  	<div class="form-group">
				  		<label class="col-sm-3 control-label" for="grp_title">FTP ID</label>
				    	<div class="col-sm-7">
				      		<input class="form-control input-sm" maxlength="80" id="svr_id" type="text" placeholder="FTP ID" required>
				    	</div>
				  	</div>
				  	<div class="form-group mbz">
				  		<label class="col-sm-3 control-label" for="grp_title">FTP PW</label>
				    	<div class="col-sm-7">
				      		<input class="form-control input-sm" maxlength="80" id="svr_pw" type="text" placeholder="FTP PW" required>
				    	</div>
				  	</div>
				</form>
			</div>
		    <div class="modal-footer">
		    	<button type="button" class="btn btn-danger btn-sm dn" onclick="svrDelete()" id="all_delete"><i class="glyphicon glyphicon-floppy-disk"></i> <nobr>삭제</nobr></button>
		        <button type="button" class="btn btn-success btn-sm" onclick="svrInsert('I')" id="all_save"><i class="glyphicon glyphicon-floppy-disk"></i> <nobr is="등록" us="수정"></nobr></button>
		    </div>
		</div>
		
	</div>
</div>