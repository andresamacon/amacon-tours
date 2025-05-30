<?php
// 1) Solo admitimos POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.html");
    exit;
}

// 2) Recogemos y saneamos
$nombre   = strip_tags(trim($_POST["nombre"]   ?? ""));
$apellido = strip_tags(trim($_POST["apellido"] ?? ""));
$email    = filter_var(trim($_POST["email"]    ?? ""), FILTER_SANITIZE_EMAIL);
$telefono = strip_tags(trim($_POST["telefono"] ?? ""));
$consulta = strip_tags(trim($_POST["consulta"] ?? ""));

// 3) Validamos
if (empty($nombre) || empty($apellido) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($consulta)) {
    echo "Por favor completa todos los campos correctamente.";
    exit;
}

// 4) Preparamos el correo
$para   = "andres@amacon.com.ar";              // ← pon aquí tu email
$asunto = "Consulta web de $nombre $apellido";
$cuerpo  = "Has recibido una nueva consulta:\n\n";
$cuerpo .= "Nombre: $nombre $apellido\n";
$cuerpo .= "Email: $email\n";
$cuerpo .= "Teléfono: $telefono\n\n";
$cuerpo .= "Mensaje:\n$consulta\n";

// 5) Cabeceras
$cabeceras  = "From: $nombre <$email>\r\n";
$cabeceras .= "Reply-To: $email\r\n";
$cabeceras .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// 6) Enviamos
if (mail($para, $asunto, $cuerpo, $cabeceras)) {
    header("Location: gracias.html");
    exit;
} else {
    echo "Lo siento, hubo un error al enviar tu consulta. Por favor intenta más tarde.";
    exit;
}
?>
