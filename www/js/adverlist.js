
var ads_form_template = "";

$(document).ready(function(){
	'use strict';

	ads_form_template = $(".ads_form_body").clone().wrapAll("<div/>").parent().html();
	$(".ads_form_body").remove();
	adFormAdd();
	
	//테이블 검색 및 등록 결과가 없을 경우..
	$("#ql tbody tr").length == 0 && $("#ql tbody").append("<tr><td class='ql_empty' colspan='"+$("#ql thead tr th").length+"'>목록 또는 검색 결과가 존재하지 않습니다.</td></tr>");
	
	//페이징 갯수 셀렉트박스 컨트롤
	$("select[name='pageselect']").change(function(){
		setCookie("adverlist_pageselect",$(this).val(),365*10);
		document.location.href = '/index.php?cn=adverlist';
	});
	
	$("#make_ads").click(function(){
		adFormInit();
		adFormAdd();
	});
	
	$(".modal").scroll(function(){ $(this).stop(); }); //부트스트랩 모달 스크롤 버그로 인한 스크립트 처리
	
	categorySelectInit(); //카테고리 리스트 
	categoryListInit();   //카테고리 리스트 
});

function categorySelectInit(){
	$("#grp_category").html("");
	var param = "type=category_list";
	var sfunc = function(data){ 
					var rt = "";
					$(data).find("item").each(function(){
						var cs = $(this).find("seq").text();
						var ct = $(this).find("title").text();
						
						$("#grp_category").append("<option value='"+cs+"'>"+ct+"</option>");
					});
					
			    };
	ajax(param,sfunc);
}

function categoryListInit(){
	$(".cateogry_iud_list").html("");
	var param = "type=category_list";
	var sfunc = function(data){ 
					var rt = "";
					$(data).find("item").each(function(){
						var cs = $(this).find("seq").text();
						var ct = $(this).find("title").text();
						
						rt += '<div class="form-group">';
						rt += '   <div class="col-sm-8">';
						rt += '		 <input class="form-control input-sm" maxlength="33" type="text" id="category_title_'+cs+'" value="'+ct+'">';
						rt += '	  </div>';
						rt += '	  <div class="col-sm-3">';
						rt += '	     <button type="button" class="btn btn-success btn-sm" onclick="categoryUpdate($(this))" seq="'+cs+'">수정</button>';
						rt += '      <button type="button" class="ml5 btn btn-danger btn-sm" onclick="categoryDelete($(this))" seq="'+cs+'">삭제</button>';
						rt += '   </div>';
						rt += '</div>';
					});
					$(".cateogry_iud_list").append(rt);
			    };
	ajax(param,sfunc);
}

function categoryInsert(){
	var t = $("#category_title").val();
	
	if(t == ""){
		alert("카테고리명을 등록하여 주십시요.");
		$("#category_title").focus();
		return false;
	}else{
		var param = "type=category_insert&title="+t;
		var sfunc = function(data){ 
						if($(data).find("result").text() == "SUCCESS"){
 							$("#category_title").val("");
 							categoryListInit();
 							categorySelectInit();
						}else{
							alert("오류 : DB등록"); 
						}
				    };
		ajax(param,sfunc);
	}
}

function categoryUpdate(obj){
	var seq = obj.attr("seq");
	var title = $("#category_title_"+seq).val();
	
	if(title == ""){
		alert("카테고리명을 입력하여 주십시요.");
		$("#category_title_"+seq).focus();
		return false;
	}else{
		var param = "type=category_update&seq="+seq+"&title="+title;
		var sfunc = function(data){ 
						if($(data).find("result").text() == "SUCCESS"){
							alert("수정 되었습니다.");
 							categoryListInit();
 							categorySelectInit();
						}else{
							alert("오류 : DB등록"); 
						}
				    };
		ajax(param,sfunc);
	}
}

function categoryDelete(obj){
	var seq = obj.attr("seq");
	
	if(confirm('삭제 하시겠습니까?')){
		var param = "type=category_delete&seq="+seq;
		var sfunc = function(data){ 
						var r = $(data).find("result").text();
						if(r == "SUCCESS"){
							categoryListInit();
							categorySelectInit();
						}else if(r == "REJECT"){
							alert("해당 카테고리로 이미 등록된 광고그룹이 존재하므로 삭제가 불가능 합니다."); 
						}else{
							alert("오류 : DB등록"); 
						}
				    };
		ajax(param,sfunc);
	}
}

function categoryUseyn(obj){
	//카테고리 사용 여부에 따른 class 처리
	var e = obj.parent().parent().parent().parent();
	if(obj.val() == "Y"){
		e.removeClass("adsusen").addClass("adsusey");
	}else{
		e.removeClass("adsusey").addClass("adsusen");
	}
}

function preview(obj){
	$("#preview_body").html("");
	var e = obj.parent().next().find("textarea").val();
	e = e == "" ? "미리보기 없음" : e;
	$("#preview_body").html(e);
}

function adFormAdd(){
	var ads_num = $(".ads_form_body").length + 1;
	var ads_seq = ads_num;
	var t = ads_form_template;
	
	t = t.replace(/\[AD_NUM\]/gi,ads_seq);
	t = t.replace(/\[AD_SEQ\]/gi,ads_seq);
	
	$("#ads_form_wrap .modal-footer").before(t);
	$(".ads_form_body").removeClass("dn");
	$(".ad_sdate, .ad_edate").datetimepicker({locale: 'ko', format: 'YYYY-MM-DD HH:mm'});

	//$("#ads_form").animate({ scrollTop: $("#ads_form_wrap").height() }, 500);
	$("#ads_form").scrollTop($("#ads_form_wrap").height());
}

function adFormSave(type){
	var gv1 = $("#grp_useyn").val();
	var gv2 = $("#grp_category").val();
	var gv3 = $("#grp_title").val();
	var pobj1 = adsSubmitChk1();
	var pobj2 = adsSubmitChk2();
	
	if(gv3 == ""){
		alert("광고그룹명을 입력하여 주십시요.");
		$("#grp_title").focus();
		return false;
	}else if(pobj1 != ""){
		alert("스크립트는 입력되었으나 광고명이 입력 안된 필드가 존재 합니다.");
		pobj1.find(".ad_title").focus();
		return false;
	}else if(pobj2 != ""){
		alert("노출시작일이 노출종료일보다 먼저인 필드가 존재 합니다.");
		pobj2.find(".ad_edate input").focus();
		return false;
	}else{
		if(type == "I"){
			var param = "type=adform_insert&grp_useyn="+gv1+"&grp_category="+gv2+"&grp_title="+gv3;
			var sfunc = function(data){ 
							if($(data).find("result").text() == "SUCCESS"){
								$(".ads_form_body").each(function(){
									if(ads_id) adsInsert($(this),ads_id,"I");
								});
								alert("저장 되었습니다.");
								$('#ads_form').modal('hide'); 
								document.location.reload();
							}else{
								alert("오류 : DB등록"); 
							}
					    };
			ajax(param,sfunc);   	
		}
		
		if(type == "U"){
			var ads_id = $("#ads_seq").val();
			var param = "type=adform_update&grp_seq="+ads_id+"&grp_useyn="+gv1+"&grp_category="+gv2+"&grp_title="+gv3;
			var sfunc = function(data){ 
							if($(data).find("result").text() == "SUCCESS"){
								$(".ads_form_body").each(function(){
									if(ads_id) adsInsert($(this),ads_id,"U");
								});
								alert("수정 되었습니다.");
								$('#ads_form').modal('hide'); 
								document.location.reload();
							}else{
								alert("오류 : DB등록"); 
							}
					    };
			ajax(param,sfunc);
		}
	}
}

function adsSubmitChk1(){
	var returnObj = "";
	$(".ads_form_body").each(function(){
		var a = $(this).find(".ad_script").val();
		var b = $(this).find(".ad_title").val();
		if(a != "" && b == ""){
			returnObj = $(this);
			return false;
		}
	});
	
	return returnObj;
}

function adsSubmitChk2(){
	var returnObj = "";
	$(".ads_form_body").each(function(){
		var a = $(this).find(".ad_sdate input").val();
		var b = $(this).find(".ad_edate input").val();

		var dta = new Date(a);
		var dtb = new Date(b);
		if(dta > dtb){
			returnObj = $(this);
			return false;
		}
	});
	
	return returnObj;
}

function adsInsert(obj,ads_id,type){
	var ad_seq = obj.find(".script_seq").val();
	var gv0 = obj.find(".ad_title").val();       //광고제목
	var gv1 = obj.find(".ad_useyn").val();       //광고사용여부
	var gv2 = obj.find(".ad_ratio").val();       //비율
	var gv3 = obj.find(".ad_title").val();       //광고명
	var gv4 = obj.find(".ad_sdate input").val(); //노출기간 시작일
	var gv5 = obj.find(".ad_edate input").val(); //노출기간 종료일
	var gv6 = obj.find(".ad_width").val();       //가로사이즈
	var gv7 = obj.find(".ad_height").val();      //세로사이즈
	var gv8 = obj.find(".ad_script").val();      //스크립트
	gv8 = encodeURIComponent(gv8);

	if(gv3 != ""){ //광고타이틀이 없으면 insert 건너뜀
		var param = "";
		if(type == "I"){
			param = "type=ads_insert&ads_id="+ads_id+"&ad_title="+gv0+"&ad_useyn="+gv1+"&ad_ratio="+gv2+"&ad_title="+gv3+"&ad_sdate="+gv4+"&ad_edate="+gv5+"&ad_width="+gv6+"&ad_height="+gv7+"&ad_script="+gv8;
			var sfunc = "";
			ajax(param,sfunc);	
		}
		if(type == "U"){
			param = "type=ads_update&ads_id="+ads_id+"&ad_seq="+ad_seq+"&ad_title="+gv0+"&ad_useyn="+gv1+"&ad_ratio="+gv2+"&ad_title="+gv3+"&ad_sdate="+gv4+"&ad_edate="+gv5+"&ad_width="+gv6+"&ad_height="+gv7+"&ad_script="+gv8;
			var sfunc = "";
			ajax(param,sfunc);	
		}
		
	}
}

function adsUpdateForm(seq){
	$(".ads_form_body").remove();
	var param = "type=ads_list&seq="+seq;
	var sfunc = function(data){ 
					adFormInit();
					$(".modal-header .modal-title").text("광고그룹수정");
					$("#all_save nobr").text($("#all_save nobr").attr("us"));
					$("#all_del").removeClass("dn");
					$("#all_save").attr("onclick","adFormSave('U')");
					$("#ads_seq").val(seq);
					var grp_useyn = $(data).find("grp_useyn").text();
					var grp_title = $(data).find("grp_title").text();
					var grp_category = $(data).find("grp_category").text();
					$("#grp_useyn").val(grp_useyn);
					$("#grp_category").val(grp_category);
					$("#grp_title").val(grp_title);
					
					$(data).find("item").each(function(n){
						adFormAdd();
						var seq = $(this).find("seq").text();
						var useyn = $(this).find("useyn").text();
						var ratio = $(this).find("ratio").text();
						var title = $(this).find("title").text();
						var sdate = $(this).find("sdate").text();
						var edate = $(this).find("edate").text();
						var width = $(this).find("width").text();
						var height = $(this).find("height").text();
						var script = $(this).find("script").text();
						
						var obj = $("#ads_form_body_"+(n+1));
						obj.find(".script_seq").val(seq);
						obj.find(".ad_useyn").val(useyn);
						obj.find(".ad_ratio").val(ratio);
						obj.find(".ad_title").val(title);
						obj.find(".ad_sdate input").val(sdate);
						obj.find(".ad_edate input").val(edate);
						obj.find(".ad_width").val(width);
						obj.find(".ad_height").val(height);
						obj.find(".ad_script").val(script);
						
						if(useyn == "N") obj.removeClass("adsusey").addClass("adsusen");
					}); 
			    };
	ajax(param,sfunc);
}

function adFormInit(){
	//입력창 초기화
	$(".modal-header .modal-title").text("광고그룹생성");
	$("#all_save nobr").text($("#all_save nobr").attr("is"));
	$("#all_del").addClass("dn");
	$("#all_save").attr("onclick","adFormSave('I')");
	$("#ads_seq").val("");
	$(".script_seq").val("");
	$("#grp_useyn option:eq(0)").attr("selected", "selected");
	$("#grp_category option:eq(0)").attr("selected", "selected");
	$("#grp_title").val("");
	$(".ads_form_body").remove();
}

function adFormDel(seq){ 
	var obj = $("#ads_form_body_"+seq);
	if(obj.find(".script_seq").val() != ""){
		if(confirm('광고를 삭제 하시겠습니까?')){
			var param = "type=ad_delete&ad_seq="+obj.find(".script_seq").val();
			var sfunc = "";
			ajax(param,sfunc);
			obj.remove();
			$(".ads_form_body").each(function(e){
				$(this).find(".modal_badge").text(e+1);
			});
		}
	}else{
		obj.remove();
		$(".ads_form_body").each(function(e){
			$(this).find(".modal_badge").text(e+1);
		});
	}
}

function adsAllDel(){
	if(confirm('그룹 전체 삭제 하시겠습니까?')){
		var param = "type=all_delete&ads_seq="+$("#ads_seq").val();
		var sfunc = "";
		ajax(param,sfunc);
		$('#ads_form').modal('hide'); 
		document.location.reload();
	}
}