<?php
function conectarDB() {
    // Configuración de la base de datos
    $host     = "localhost";
    $usuario  = "root";
    $password = "";
    $dbName   = "cafe_luna";
    // Intentar crear la conexión
    $conexion = new mysqli($host, $usuario, $password, $dbName);
    // Verificar si hubo un error en la conexión
    if ($conexion->connect_error) {
        // En producción es mejor guardar esto en un archivo log y no mostrarlo al usuario
        error_log("Error de conexión a la BD: " . $conexion->connect_error);
        return false;
    }
    // Configurar el juego de caracteres a UTF-8 (para evitar problemas con tildes y la Ñ)
    $conexion->set_charset("utf8");
    // Devolver el objeto de conexión listo para usarse
    return $conexion;
}
?>