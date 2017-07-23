function login() {
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "/accounts/login",
        data: {
            'email' : email,
            'password' : password
        },
        success: function(data){
            if(data === "Неверный пароль или Email"){
                $(".panel-title").append('<br/><span class="link-danger">'+ data +'</span><br/>');
            }
            else{
                window.location.replace("http://localhost:8080/messages");
            }
        }
    });
}
