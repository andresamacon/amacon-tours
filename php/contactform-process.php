<?php
// contactform-process.php

// Configuración del correo destino y asunto
$to = "andres@amacon.com.ar";
$subject = "Nueva Consulta desde Amacon Tours";

// Recoger y limpiar los datos enviados por POST
$nombre   = isset($_POST['nombre']) ? strip_tags(trim($_POST['nombre'])) : "";
$apellido = isset($_POST['apellido']) ? strip_tags(trim($_POST['apellido'])) : "";
$email    = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : "";
$telefono = isset($_POST['telefono']) ? strip_tags(trim($_POST['telefono'])) : "";
$consulta = isset($_POST['consulta']) ? strip_tags(trim($_POST['consulta'])) : "";

// Validar datos básicos
if (empty($nombre) || empty($apellido) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($consulta)) {
    // Si falta algún dato esencial, devolvemos error
    http_response_code(400);
    echo "Por favor completa el formulario correctamente.";
    exit;
}

// Construir el cuerpo del mensaje
$message  = "Has recibido una nueva consulta desde Amacon Tours:\n\n";
$message .= "Nombre: $nombre $apellido\n";
$message .= "Email: $email\n";
$message .= "Teléfono: $telefono\n\n";
$message .= "Consulta:\n$consulta\n";

// Encabezados del correo
$headers  = "From: $nombre $apellido <{$email}>\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "Content-type: text/plain; charset=UTF-8\r\n";

// Intentar enviar el correo
if (mail($to, $subject, $message, $headers)) {
    http_response_code(200);
    echo "¡Gracias! Tu consulta ha sido enviada.";
} else {
    http_response_code(500);
    echo "Hubo un problema al enviar tu consulta. Por favor, intenta de nuevo.";
}
?>
