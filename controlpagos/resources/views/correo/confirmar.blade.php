<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Verificacion de su correo electronico</h2>

        <div>
            Gracias por crear tu cuenta en nuestro sistema.
            Por favor presiona el siguiente link para confirmar tu correo electronico.
            {{ URL::to('medicos/verificarcuenta/' . $codigo_confirmacion) }}.<br/>

        </div>

    </body>
</html>