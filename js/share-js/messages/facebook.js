function checkLoginState(){
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function statusChangeCallback(response){
    FB.login(function(response) {
        if (response.authResponse) {
            console.log('Welcome!  Fetching your information.... ');
            FB.api('/me', {fields: "id,name,email"}, function(response) {
                var email = response.email;
                $.ajax({
                    type: "POST",
                    url: "/accounts/facebook_auth",
                    data: {
                        'Email' : email
                    },
                    success: function(){
                        location.reload();
                    }
                });
            });
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    },{scope: 'email'});
}