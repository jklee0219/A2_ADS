function logout(){
	if(confirm('로그아웃 하시겠습니까?')){
		document.location.href = "/comm/proc.php?type=logout";
	}
}

//쿠키 생성
function setCookie(cName, cValue, cDay){
    var expire = new Date();
    expire.setDate(expire.getDate() + cDay);
    cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
    if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
    document.cookie = cookies;
}

//쿠키 가져오기
function getCookie(cName) {
    cName = cName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cName);
    var cValue = '';
    if(start != -1){
        start += cName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cValue = cookieData.substring(start, end);
    }
    return unescape(cValue);
}

//ajax call
function ajax(param,success_func){
	$.ajax({
		async: false,
	    url: "/comm/proc_ajax.php",
	    type: "POST",
	    data: param,
	    dataType: 'xml',
	    error: function(xhr, status, error) {
	    	alert("오류 : "+error);
	    },
	    success: function(data) {
	    	$.isFunction(success_func) && success_func(data);
	    }
	});
}