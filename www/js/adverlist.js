$(function(){
	'use strict';
	//테이블 검색 및 등록 결과가 없을 경우..
	$("#ql tbody tr").length == 0 && $("#ql tbody").append("<tr><td class='ql_empty' colspan='"+$("#ql thead tr th").length+"'>목록 또는 검색 결과가 존재하지 않습니다.</td></tr>");
	
	$("select[name='pageselect']").change(function(){
		setCookie("adverlist_pageselect",$(this).val(),365*10);
		document.location.reload();
	});
});