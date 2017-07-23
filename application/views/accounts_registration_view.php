<div class="loginform">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Регистрация</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/accounts/registration">
                            <fieldset>
                                <div class="form-group">
                                    <input id="email" class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                                </div>
                                <div class="form-group">
                                    <input id="password" class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <a href="javascript:saveNewUser()" class="btn btn-success btn-block">Регистрация</a>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/js/share-js/accounts/registration.js" type="text/javascript"></script>