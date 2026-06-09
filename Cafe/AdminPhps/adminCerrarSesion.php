<?php
session_start();

// Destruir la sesión
session_destroy();

// Borrar la cookie de "recordar sesión" poniendo su fecha de expiración en el pasado.
// El navegador elimina automáticamente las cookies que ya vencieron.
setcookie("recordar_correo", "", time() - 3600, "/");

header("Location: ../login.php");
exit();
?>