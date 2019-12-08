function hideShowPassword() {
    var paswword = document.getElementById("password");
    if(paswword.type === "password"){
       paswword.type = "text";
    }
    else {
        paswword.type = "password";
    }
}