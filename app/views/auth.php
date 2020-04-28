<?
    
?>

<div class="container-fluid container-main">
    <div class="container d-flex justify-content-end">
        <a href="/"><button class="btn btn-primary btn-sm mt-md-3">На главную</button></a>
	</div>
    <div class="container container-auth">
        <h3>Авторизация</h3>
        <form>
            <div class="form-group row">
                <label for="auth-login" class="col-sm-2 col-form-label">Логин</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="auth-login">
                </div>
            </div>
            <div class="form-group row">
                <label for="auth-pass" class="col-sm-2 col-form-label">Пароль</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="auth-pass">
                </div>
            </div>
            <button id="sign" class="btn btn-primary btn-sm">Войти</button>
        </form>
        <div role="alert" class="alert alert-danger check-empty mt-2 hidden">Все поля обязательны для заполнения</div>
        <div role="alert" class="alert alert-danger check-auth mt-2 hidden">Неверно введен логин или пароль</div>
    </div>
</div>