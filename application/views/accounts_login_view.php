<div class="loginform">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Вход</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/accounts/login">
                            <fieldset>
                                <div class="form-group">
                                    <input id="email" class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="password" class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <a href="javascript:login()" class="btn btn-success btn-block">Войти</a>
                                <p class="signUp-link">Новый пользователь? <a href="accounts/registration" class="text-warning">Регистрация</a></p>
                            </fieldset>
                            <p class="text-center">
                                <fb:login-button scope="public_profile,email" autologoutlink="true" onlogin="checkLoginState();">
                                </fb:login-button>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/share-js/accounts/facebook.js" type="text/javascript"></script>
<script src="/js/share-js/accounts/login.js" type="text/javascript"></script>