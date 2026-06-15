<?php
// Verificamos que el formulario fue enviado por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Limpiamos los datos recibidos del formulario
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $correo = htmlspecialchars(trim($_POST["correo"]));
    $telefono = htmlspecialchars(trim($_POST["telefono"]));
    $asunto = htmlspecialchars(trim($_POST["asunto"]));
    $mensaje = htmlspecialchars(trim($_POST["mensaje"]));

    // Verificamos que los campos obligatorios no estén vacíos
    if (empty($nombre) or empty($correo) or empty($asunto) or empty($mensaje)) {
        echo "<p style='color:red;'>Error: Faltan campos obligatorios por llenar.</p>";
    } else {

        // Asignamos una categoría interna según el asunto seleccionado
        switch ($asunto) {
            case "Cotizacion":
                $categoria = "Ventas";
                break;
            case "Duda":
                $categoria = "Atencion al Cliente";
                break;
            case "Reclamo":
                $categoria = "Urgente";
                break;
            case "Reservacion":
                $categoria = "Logistica";
                break;
            case "Trabajo":
                $categoria = "Recursos Humanos";
                break;
            default:
                $categoria = "General";
        }

        // Formateamos el registro para guardarlo en el archivo
        $registro = "Nombre: $nombre | Correo: $correo | Teléfono: $telefono | Asunto: $asunto [$categoria] | Mensaje: $mensaje" . PHP_EOL;

        // Guardamos el registro en el archivo de contactos
        $archivo = 'contactos.txt';
        file_put_contents($archivo, $registro, FILE_APPEND);

        // Redirigimos con mensaje de éxito
        header("Location: Contactanos.php?enviado=1");
        exit();
    }

} else {
    // Si alguien intenta acceder directamente al archivo sin enviar el formulario
    die("No se han recibido datos.");
}
?>