function saveNewUser() {
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
        type: "POST",
        url: "/accounts/save_new_user",
        data: {
            'email' : email,
            'password' : password
        },
        success: function(data){
            if(data === "Пользователь с таким Email уже зарегистрирован."){
                $(".panel-title").append('<br/><span class="link-danger">'+ data +'</span><br/>');
            }
            else{
                window.location.replace("http://localhost:8080/");
            }
        }
    });
}