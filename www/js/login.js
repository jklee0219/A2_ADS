function validateForm() {
    var password = document.forms["loginFrm"]["pw"];
    if (password.value == null || password.value == "") {
        alert("비밀번호를 입력하여 주십시요");
        password.focus();
        return false;
    }

    loginFrm.submit();
}