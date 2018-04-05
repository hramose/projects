@include('layaout.header')
<!--
 * parallax_login.html
 * @Author original @msurguy (tw) -> http://bootsnipp.com/snippets/featured/parallax-login-form
 * @Tested on FF && CH
 * @Reworked by @kaptenn_com (tw)
 * @package PARALLAX LOGIN.
-->

<?php 
    if (isset($_REQUEST["mensaje"]))
        $mensaje=$_REQUEST["mensaje"];

    if ($mensaje=="error")
        echo "<div class='alert alert-danger'><strong>Debe estar autenticado en nuestro sistema</strong></div>";
    elseif ($mensaje=="error_autenticacion")
        echo "<div class='alert alert-danger'><strong>Usuario y/o Contraseña invalidos</strong></div>";
 ?>

{!! Form::open(array('url' => 'verificar_usuario', 'method' => 'post', 'class' =>  "form-horizontal")) !!}
<div class="container">
    <div class="row vertical-offset-100">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row-fluid user-row" align="center">
                        <img src="{{ URL::asset('images/tuerca.jpg') }}" class="img-responsive" alt="Sign In"/>
                    </div>
                </div>
                <div class="panel-body">
                        <fieldset>
                            <label class="panel-login">
                                <div class="login_result"></div>
                            </label>
                            <input value="" required="required" autocomplete="off" placeholder="Email" class="form-control" placeholder="Username" name="username" id="username" type="text">
                            <input value="" data-validate-length="6,8" type="password" required="required" placeholder="Password" class="form-control" placeholder="Password" name="password" id="password" type="password">
                            <br />
                            <div class="ln_solid"></div>
                            <div class="form-group" align="center">
                            <!--{!! Form::button('send', array('class'=>'send-btn', 'class'=>'btn btn-primary','onclick'=>'validar_especialidad(this.form)')) !!}-->
                            <button id="send" type="submit" class="btn btn-success">Ingresar</button>
                            </div>                            
                            <br /><br />
                            <div align="center">
                                <a href="{{ route('nuevo_medico') }}"><button type="button" class="btn btn-primary">Nuevo Usuario</button></a>
                                <a href="javascript:;" onclick="validar_usuario_olvido()"><button type="button" class="btn btn-danger">Olvido su contraseña</button></a>
                            </div>
                        </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@include('layaout.footer')