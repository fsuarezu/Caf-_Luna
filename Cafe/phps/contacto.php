<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    $nombre = htmlspecialchars(trim($_POST['nombre'] ));
    $correo = htmlspecialchars(trim($_POST["correo"] ));
    $telefono = htmlspecialchars(trim($_POST["telefono"] ));
    $asunto = htmlspecialchars(trim($_POST["asunto"] ));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"] ));

    if(empty($nombre) or empty($correo) or empty($asunto) or empty($mensaje)){
        echo "<p style='color:red;'>Error: Faltan campos obligatorios por llenar.</p>";
    } else {
        
        switch($asunto){
            case "Cotizacion":
                $categoria="Ventas";
            case "Duda":
                $categoria="Atencion al Cliente";
            case "Reclamo":
                $categoria="Urgente";
            case "Reservacion":
                $categoria="Logistica";
            case "Trabajo":
                $categoria="Recursos Humanos";
        }

        
        $registro = "Nombre: $nombre | Correo: $correo | Teléfono: $telefono | Asunto: $asunto [$categoria] | Mensaje: $mensaje" . PHP_EOL;

        $archivo = 'contactos.txt';
        file_put_contents($archivo, $registro, FILE_APPEND | LOCK_EX);

        header("Location: Contactanos.php?enviado=1");
        exit();
    }

} else {
    die("No se han recibido datos.");
}
?>