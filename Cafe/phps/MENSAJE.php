<?php
// Variables con los estilos de los mensajes para no repetir código
$esVerde = "background-color: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 15px;";
$esRojo = "background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 15px;";

// Si se generó un token de recuperación, mostramos el enlace para resetear la contraseña
if (isset($_GET['enviado']) && isset($_GET['token'])): ?>
    <div style="<?php echo $esVerde; ?>">
        Token generado. <a href="resetear.php?token=<?php echo $_GET['token']; ?>">Click aquí para cambiar tu contraseña</a>
    </div>

<?php // Si se envió el formulario de contacto exitosamente
elseif (isset($_GET['enviado'])): ?>
    <div style="<?php echo $esVerde; ?>">
        <strong>¡Éxito!</strong> Su consulta ha sido enviada.
        <a href="Contactanos.php" style="float:right; text-decoration:none; color:#155724; font-weight:bold;">&times;</a>
    </div>

<?php // Si se actualizó la contraseña correctamente
elseif (isset($_GET['resetead'])): ?>
    <div style="<?php echo $esVerde; ?>">
        Contraseña actualizada correctamente.
    </div>

<?php // Si ocurrió algún error, buscamos el mensaje correspondiente
elseif (isset($_GET['error'])): ?>
    <?php
    $mensajes = [
        // Error al iniciar sesión: correo no existe o contraseña incorrecta
        '1'=>'Correo o contraseña incorrectos.',

        // Error en el formulario de pago: el nombre tiene menos de 3 caracteres
        'nombre'=>'El nombre debe tener al menos 3 caracteres.',

        // Error de acceso directo: alguien intentó entrar al PHP sin pasar por el formulario
        'acceso'=>'Acceso no permitido.',

        // Error en recuperación de contraseña: el correo ingresado no existe en la BD
        'correo'=>'El correo ingresado no existe.',

        // Error en recuperación de contraseña: el token venció o no es válido
        'token'=>'El enlace ha vencido o no es válido.',

        // Error de rol: el rol seleccionado no coincide con la cuenta
        'rol'=>'El rol seleccionado no corresponde a esta cuenta.',
        // Error de stock insuficiente
        'stock'=> isset($_GET['msg']) ? htmlspecialchars($_GET['msg']) : 'No hay suficiente stock para completar la compra.',
    ];

    // Si el error no está en el arreglo, mostramos un mensaje genérico
    $msg = $mensajes[$_GET['error']] ?? 'Ha ocurrido un error.';
    ?>
    <div style="<?php echo $esRojo; ?>">
        <?php echo $msg; ?>
    </div>

<?php endif; ?>