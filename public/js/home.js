var email = document.getElementById("email");
var emailError = document.getElementById("emailError")

news_email.addEventListener("keydown",function(){
    var valEmail = "^([a-zA-Z0-9]+[a-zA-Z0-9._%-]*@(?:[a-zA-Z0-9-])+(\.+[a-zA-Z]{2,4}){1,2})$"
    var validateEmail = (valEmail.test(email.value))?emailErrortextContent="" : email.textContent = "Valid email required";
});
