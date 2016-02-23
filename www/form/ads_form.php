<!-- 광고등록폼 -->
<div id="ads_form" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		
		<div class="modal-content" id="ads_form_wrap">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">광고그룹생성</h4>
		    </div>
		    <div class="modal-body">
		    	<form class="form-horizontal" role="form">
					<input type="hidden" id="ads_seq" value="">
		    		<div class="form-group">
				  		<label class="col-sm-2 control-label" for="grp_useyn">그룹사용여부</label>
				  		<div class="col-sm-2">
					    	<select id="grp_useyn" class="form-control input-sm">
							    <option value="Y">사용</option>
							    <option value="N">중지</option>
							</select>
						</div>
				  	</div>
		    		<div class="form-group">
				  		<label class="col-sm-2 control-label" for="grp_category">카테고리</label>
				  		<div class="col-sm-6">
					    	<select id="grp_category" class="form-control input-sm fl"></select>
					    	<button type="button" class="btn btn-success btn-sm ml5 fl" data-toggle="modal" data-target="#category_form">카테고리관리</button>
						</div>
				  	</div>
				  	<div class="form-group mbz">
				  		<label class="col-sm-2 control-label" for="grp_title">광고그룹명</label>
				    	<div class="col-sm-9">
				      		<input class="form-control input-sm" maxlength="160" id="grp_title" type="text" placeholder="광고그룹명" required>
				    	</div>
				  	</div>
				</form>
			</div>
			<div class="modal-body ads_form_body mbt adsusey dn" id="ads_form_body_[AD_SEQ]">
				<p class="modal_badge">[AD_NUM]</p>
				<p class="modal_del_btn"><button type="button" class="btn btn-danger btn-sm" tabindex="-1" onclick="adFormDel('[AD_SEQ]')"><i class="glyphicon glyphicon-remove"></i> 광고 삭제</button></p>
				<form class="form-horizontal" role="form">
					<input type="hidden" class="script_seq" value="">
				  	<div class="form-group">
				  		<label class="col-sm-2 control-label">광고사용여부</label>
				  		<div class="col-sm-2">
					    	<select class="form-control input-sm ad_useyn" onchange="categoryUseyn($(this));">
							    <option value="Y">사용</option>
							    <option value="N">중지</option>
							</select>
						</div>
					</div>
					<div class="form-group">
				  		<label class="col-sm-2 control-label">비율</label>
				  		<div class="col-sm-2">
					    	<select class="form-control input-sm ad_ratio">
					    		<?php for($i=1; $i<10; $i++){?>
					    		<option value="<?=$i?>"><?=$i?></option>
					    		<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">광고명</label>
				  		<div class="col-sm-9">
					    	<input class="form-control input-sm ad_title" maxlength="160" type="text" placeholder="광고명">
						</div>
				  	</div>
				  	<div class="form-group">
						<label class="col-sm-2 control-label">노출기간</label>
				  		<div class="col-sm-3">
				  			<div class='input-group date ad_sdate'>
			                    <input type='text' class="form-control input-sm" maxlength="24" placeholder="시작일">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
						</div>
						<label class="midtxt">&#126;</label>
						<div class="col-sm-3">
				  			<div class='input-group date ad_edate'>
			                    <input type='text' class="form-control input-sm" maxlength="24" placeholder="종료일">
			                    <span class="input-group-addon">
			                        <span class="glyphicon glyphicon-calendar"></span>
			                    </span>
			                </div>
						</div>
				  	</div>
				  	<div class="form-group">
						<label class="col-sm-2 control-label">사이즈</label>
				  		<div class="col-sm-2">
					    	<input type="number" name="quantity" min="1" max="999" class="form-control input-sm ad_width"  placeholder="가로">
						</div>
						<label class="midtxt">&times;</label>
						<div class="col-sm-2">
							<input type="number" name="quantity" min="1" max="999" class="form-control input-sm ad_height"  placeholder="세로">
						</div>
				  	</div>
				  	<div class="form-group mbz">
						<label class="col-sm-2 control-label">
							스크립트<br/><button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#preview_form" tabindex="-1" onclick="preview($(this))">미리보기</button>
						</label>
				  		<div class="col-sm-9">
					    	<textarea class="form-control input-sm ad_script" rows="5" placeholder="광고 스크립트"></textarea>
						</div>
				  	</div>
				</form>
		    </div>
		    <div class="modal-footer">
		    	<button type="button" class="btn btn-success btn-sm" onclick="adFormAdd()"><i class="glyphicon glyphicon-plus-sign"></i> 광고 추가</button>
		        <button type="button" class="btn btn-success btn-sm" onclick="adFormSave('I')" id="all_save"><i class="glyphicon glyphicon-floppy-disk"></i> <nobr is="그룹 전체 저장" us="그룹 전체 수정"></nobr></button>
		    	<button type="button" class="btn btn-danger btn-sm dn" id="all_del" onclick="adsAllDel()"><i class="glyphicon glyphicon-remove"></i> 그룹 전체 삭제</button>
		    </div>
		</div>
		
	</div>
</div>

<!-- 카테고리등록폼 -->
<div id="category_form" class="modal fade ativa-scroll" role="dialog">
	<div class="modal-dialog">
		
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">카테고리 관리</h4>
		    </div>
		    <div class="modal-body">
		    	<form class="form-horizontal" role="form" onsubmit="categoryInsert(); return false;">
		    		<div class="form-group">
				  		<div class="col-sm-8">
				      		<input class="form-control input-sm" maxlength="33" id="category_title" type="text">
				    	</div>
				  		<div class="col-sm-3">
					    	<button type="submit" class="btn btn-success btn-sm">신규등록</button>
						</div>
				  	</div>
				</form>
				<form class="form-horizontal cateogry_iud_list" role="form"></form>
		    </div>
		</div>
		
	</div>
</div>

<!-- 미리보기폼 -->
<div id="preview_form" class="modal fade ativa-scroll" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">광고 미리보기</h4>
		    </div>
		    <div class="modal-body" id="preview_body"></div>
		</div>
	</div>
</div>