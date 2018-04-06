@include('layaout.header')
<!--
 * parallax_login.html
 * @Author original @msurguy (tw) -> http://bootsnipp.com/snippets/featured/parallax-login-form
 * @Tested on FF && CH
 * @Reworked by @kaptenn_com (tw)
 * @package PARALLAX LOGIN.
-->

{!! Form::open(array('url' => 'verificar_usuario', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row-fluid user-row">
                        <img src="http://s11.postimg.org/7kzgji28v/logo_sm_2_mr_1.png" class="img-responsive" alt="Sign In"/>
                    </div>
                </div>
                <div class="panel-body">
                        <fieldset>
                            <label class="panel-login">
                                <div class="login_result"></div>
                            </label>
                            <input class="form-control" placeholder="Username" name="username" type="text">
                            <input class="form-control" placeholder="Password" name="password" type="password">
                            <br><br>
                            <input class="btn btn-lg btn-success btn-block" type="button" onclick="verificar_usuario(this.form)" id="login" value="Login">
                        </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@include('layaout.footer')