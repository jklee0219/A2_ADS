<?php
$qry  = " select * from TB_ADS ";
$qr   = getQueryResult($qry);
$pscv = $_COOKIE['adverlist_pageselect'];
?>
<div class="content_wrap">
	<nav id="list_nav">
	  	<select class="form-control" name="pageselect">
		    <option <?=$pscv==10 ? "selected='selected'" : ""?> value="10">10</option>
		    <option <?=$pscv==50 ? "selected='selected'" : ""?> value="50">50</option>
		    <option <?=$pscv==100 ? "selected='selected'" : ""?> value="100">100</option>
		    <option <?=$pscv==999 ? "selected='selected'" : ""?> value="999">∞</option>
		</select>
		<ul class="pagination pagination-sm">
	    	<li><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
		    <li><a href="#">1</a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		    <li><a href="#">5</a></li>
	    	<li><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
	  	</ul>
	  	<div class="fr">
		  	<input type="text" class="fl ml5 form-control" name="searchstr" placeholder="검색">
		  	<input type="submit" class="fl ml5 btn btn-primary btn-sm" value="검색">
		  	<button type="button" class="fl ml5 btn btn-success btn-sm" data-toggle="modal" data-target="#ads_form">광고영역생성</button>
		</div>
	</nav>
	
	<table id="ql" class="table table-striped table-bordered" cellspacing="0">
        <thead>
            <tr>
                <th>카테고리</th>
                <th>광고명</th>
                <th>광고수</th>
                <th>사용여부</th>
                <th>등록일</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($qr as $k => $v){ ?>
            <tr>
                <td><?=$v['category_name']?></td>
                <td><?=$v['title']?></td>
                <td><?=$v['ads_cnt']?></td>
                <td><?=$v['use_str']?></td>
                <td><?=$v['wdate']?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
</div>

<!-- Modal -->
<div id="ads_form" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">광고영역생성</h4>
		    </div>
		    <div class="modal-body ads_form_body">
		    	<form class="form-horizontal" role="form">
		    		<div class="form-group">
				  		<label class="col-sm-2 control-label" for="title">사용여부</label>
				  		<div class="col-sm-2">
					    	<select class="form-control">
							    <option value="10">사용</option>
							    <option value="50">중지</option>
							</select>
						</div>
				  	</div>
		    		<div class="form-group">
				  		<label class="col-sm-2 control-label" for="title">카테고리</label>
				  		<div class="col-sm-3">
					    	<select class="form-control">
							    <option value="10">10</option>
							    <option value="50">50</option>
							</select>
						</div>
						<div class="col-sm-2">
							<button type="button" id="category_form_open" class="btn btn-success btn-md">카테고리생성</button>
						</div>
				  	</div>
				  	<div class="form-group dn">
				  		<label class="col-sm-2 control-label" for="title">카테고리명</label>
				    	<div class="col-sm-4">
				      		<input class="form-control" maxlength="33" id="title" name="title" type="text" placeholder="카테고리명" required>
				    	</div>
				    	<div class="col-sm-2">
							<button type="button" class="btn btn-success btn-md" data-toggle="modal" data-target="#ads_form">생성</button>
						</div>
				  	</div>
				  	<div class="form-group">
				  		<label class="col-sm-2 control-label" for="title">광고명</label>
				    	<div class="col-sm-9">
				      		<input class="form-control" maxlength="160" id="title" name="title" type="text" placeholder="광고명" required>
				    	</div>
				  	</div>
				</form>
		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div>
		
	</div>
</div>