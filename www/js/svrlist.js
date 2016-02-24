$(document).ready(function(){
	'use strict';
	
	//테이블 검색 및 등록 결과가 없을 경우..
	$("#ql tbody tr").length == 0 && $("#ql tbody").append("<tr><td class='ql_empty' colspan='"+$("#ql thead tr th").length+"'>목록 또는 검색 결과가 존재하지 않습니다.</td></tr>");
	
	$("#all_save nobr").text($("#all_save nobr").attr("is"));
	
	//서버ftp접속체크
	$("#ql tbody tr").each(function(){
		var v0 = $(this).find(".seq").attr("value");
		var v1 = $(this).find(".ip").text();
		var v2 = $(this).find(".port").text();
		var v3 = $(this).find(".id").text();
		var v4 = $(this).find(".pw").text();
		
		var param = "type=ftp_check&ip="+v1+"&port="+v2+"&id="+v3+"&pw="+v4;
		var sfunc = function(data){ 
						if($(data).find("result").text() == "FAIL"){
							$("#row_"+v0).find(".useyn").text("접속실패")
							$("#row_"+v0).removeClass("success");
						}
				    };
		ajax(param,sfunc);
	});
});

function svrInsert(type){
	var v1 = $("#svr_useyn").val(); //서버사용여부
	var v2 = $("#svr_title").val(); //서버명
	var v3 = $("#svr_ip").val();    //HOST IP
	var v4 = $("#svr_port").val();  //PORT
	var v5 = $("#svr_id").val();    //FTP ID
	var v6 = $("#svr_pw").val();    //FTP PW
	
	if(v2 == ""){
		alert("서버명을 등록하여 주십시요.");
		$("#svr_title").focus();
		return false;
	}else if(v3 == ""){
		alert("HOST IP를 등록하여 주십시요.");
		$("#svr_ip").focus();
		return false;
	}else if(v4 == ""){
		alert("PORT를 등록하여 주십시요.");
		$("#svr_port").focus();
		return false;
	}else if(v5 == ""){
		alert("FTP ID를 등록하여 주십시요.");
		$("#svr_id").focus();
		return false;
	}else if(v6 == ""){
		alert("FTP PW를 등록하여 주십시요.");
		$("#svr_pw").focus();
		return false;
	}else{
		if(type == "I"){
			var param = "type=svr_insert&useyn="+v1+"&title="+v2+"&ip="+v3+"&port="+v4+"&id="+v5+"&pw="+v6;
			var sfunc = function(data){ 
							if($(data).find("result").text() == "SUCCESS"){
								alert("저장 되었습니다.");
								$('#svr_form').modal('hide'); 
								document.location.reload();
							}else{
								alert("오류 : DB등록"); 
							}
					    };
			ajax(param,sfunc);
		}
		if(type == "U"){
			var seq   = $("#svr_seq").val(); 
			var param = "type=svr_update&seq="+seq+"&useyn="+v1+"&title="+v2+"&ip="+v3+"&port="+v4+"&id="+v5+"&pw="+v6;
			var sfunc = function(data){ 
							if($(data).find("result").text() == "SUCCESS"){
								alert("수정 되었습니다.");
								$('#svr_form').modal('hide'); 
								document.location.reload();
							}else{
								alert("오류 : DB등록"); 
							}
					    };
			ajax(param,sfunc);
		}
	}
}

function svrDelete(){
	if(confirm('삭제하시겠습니까?')){
		var seq   = $("#svr_seq").val(); 
		var param = "type=svr_delete&seq="+seq;
		var sfunc = function(data){ 
						if($(data).find("result").text() == "SUCCESS"){
							alert("삭제 되었습니다.");
							$('#svr_form').modal('hide'); 
							document.location.reload();
						}else{
							alert("오류 : DB등록"); 
						}
				    };
		ajax(param,sfunc);
	}
}

function svrUpdateForm(obj){
	formInit();
	var seq = obj.find(".seq").attr("value");
	var v1 = obj.find(".useyn").attr("value"); //서버사용여부
	var v2 = obj.find(".title").text(); //서버명
	var v3 = obj.find(".ip").text();    //HOST IP
	var v4 = obj.find(".port").text();  //PORT
	var v5 = obj.find(".id").text();    //FTP ID
	var v6 = obj.find(".pw").text();    //FTP PW

	$("#svr_seq").val(seq);
	$("#svr_useyn").val(v1);
	$("#svr_title").val(v2);
	$("#svr_ip").val(v3);
	$("#svr_port").val(v4);
	$("#svr_id").val(v5);
	$("#svr_pw").val(v6);
	$("#all_save nobr").text($("#all_save nobr").attr("us"));
	$("#all_save").attr("onclick","svrInsert('U')");
	$("#all_delete").removeClass("dn");
}

function formInit(){
	$("#svr_seq").val("");
	$("#svr_useyn").val("Y");
	$("#svr_title").val("");
	$("#svr_ip").val("");
	$("#svr_port").val("21");
	$("#svr_id").val("");
	$("#svr_pw").val("");
	$("#all_save nobr").text($("#all_save nobr").attr("is"));
	$("#all_save").attr("onclick","svrInsert('I')");
	$("#all_delete").removeClass("dn").addClass("dn");
}